/**
 * Real-time Ticket Status Updater with Exponential Backoff
 */
$(document).ready(function() {
    const ticketContainer = $('#ticket-container');
    const ticketId = ticketContainer.data('ticket-id');
    let currentStatus = ticketContainer.data('initial-status');
    let retryCount = 0;
    const maxRetries = 5;
    const baseDelay = 1000;

    function fetchStatus() {
        $.ajax({
            url: `/check-ticket-status/${ticketId}`,
            method: 'GET',
            dataType: 'json',
            cache: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'x-csrf-token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                retryCount = 0; // Reset retry counter on success
                if (response.status !== currentStatus) {
                    currentStatus = response.status;
                    updateTicketUI(response);
                }
                scheduleNextCheck(500); // Normal polling interval
            },
            error: function(xhr, status, error) {
                console.error('Status check failed:', error);
                if (retryCount < maxRetries) {
                    retryCount++;
                    const delay = baseDelay * Math.pow(2, retryCount);
                    scheduleNextCheck(delay);
                } else {
                    console.error('Max retries reached. Stopping updates.');
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

        // Update status badge
        $('.ticket-status').html(statusBadges[ticketData.status]);

        // Handle notifications
        const alerts = {
            processing: `
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Your ticket is now being processed!</strong>
                    <p>Please proceed to Department ${ticketData.department} to see Dr. ${ticketData.doctor}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `,
            completed: `
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Appointment Completed!</strong>
                    <p>Thank you for choosing Sun City Hospital.</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `
        };

        if (alerts[ticketData.status]) {
            $('.alert-container').html(alerts[ticketData.status]);
            if (document.getElementById('notification-sound')) {
                new Audio(document.getElementById('notification-sound').src).play()
                    .catch(e => console.log('Audio play failed:', e));
            }
            ticketContainer.addClass('bg-success-subtle');
            setTimeout(() => ticketContainer.removeClass('bg-success-subtle'), 3000);
        }

        // WebSocket fallback
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

    // Initial check
    if (ticketId) {
        fetchStatus();
        scheduleNextCheck(500);
    }
});