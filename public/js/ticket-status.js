/**
 * Real-time Ticket Status Updater with Optimized Polling
 */
$(document).ready(function() {
    const ticketContainer = $('#ticket-container');
    const ticketId = ticketContainer.data('ticket-id');
    let currentStatus = ticketContainer.data('initial-status');
    let retryCount = 0;
    const maxRetries = 5;
    const baseDelay = 1000;
    const normalPollingInterval = 1000;

    function fetchStatus() {
        $.ajax({
            url: `/check-ticket-status/${ticketId}`,
            method: 'GET',
            dataType: 'json',
            cache: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                retryCount = 0;
                if (response.ticket.status !== currentStatus) {
                    currentStatus = response.ticket.status;
                    updateTicketUI(response.ticket);
                }
                scheduleNextCheck(normalPollingInterval);
            },
            error: function(xhr, status, error) {
                console.error('Status check failed:', error);
                if (retryCount < maxRetries) {
                    retryCount++;
                    const delay = baseDelay * Math.pow(2, retryCount);
                    scheduleNextCheck(delay);
                } else {
                    console.error('Max retries reached. Stopping updates.');
                    showConnectionError();
                }
            }
        });
    }

    function scheduleNextCheck(delay) {
        setTimeout(fetchStatus, delay);
    }

    function updateTicketUI(ticketData) {
        const statusBadges = {
            processing: '<span class="badge bg-success">Now Processing</span>',
            completed: '<span class="badge bg-secondary">Completed</span>',
            waiting: '<span class="badge bg-warning text-dark">Waiting</span>'
        };

        // Animate status change
        $('.ticket-status').fadeOut(200, function() {
            $(this).html(statusBadges[ticketData.status]).fadeIn(200);
        });

        // Update notifications
        const alerts = {
            processing: `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Your ticket is now being processed!</strong>
                    <p>Please proceed to Department ${ticketData.department.name}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `,
            completed: `
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Appointment Completed!</strong>
                    <p>Thank you for choosing our clinic.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `
        };

        if (alerts[ticketData.status]) {
            $('.alert-container').html(alerts[ticketData.status]);
            playNotificationSound();
            highlightTicket();
        }

        // Update priority lane if needed
        if (ticketData.priority === 'priority') {
            $('.priority-section').removeClass('d-none');
        }
    }

    function playNotificationSound() {
        const sound = document.getElementById('notification-sound');
        if (sound) {
            sound.play().catch(e => console.log('Audio play failed:', e));
        }
    }

    function highlightTicket() {
        ticketContainer.addClass('bg-success-subtle');
        setTimeout(() => ticketContainer.removeClass('bg-success-subtle'), 3000);
    }

    function showConnectionError() {
        $('.alert-container').html(`
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Connection lost!</strong> Updates paused. Please refresh the page.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `);
    }

    // Initialize
    if (ticketId) {
        fetchStatus();
        setupWebsocket();
    }

    function setupWebsocket() {
        if (typeof Echo !== 'undefined') {
            window.Echo.private(`ticket.${ticketId}`)
                .listen('.status-updated', (data) => {
                    if (data.status !== currentStatus) {
                        currentStatus = data.status;
                        updateTicketUI(data);
                    }
                });
        }
    }
});