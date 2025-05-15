<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor Display</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .ticket-display {
            font-size: 6rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .priority-ticket {
            color: #dc3545;
        }
        .regular-ticket {
            color: #0d6efd;
        }
        .queue-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: 100%;
        }
        .priority-header {
            background-color: #dc3545;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .regular-header {
            background-color: #0d6efd;
            color: white;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        .clinic-info {
            font-size: 2rem;
            color: #343a40;
        }
        .text-muted {
            font-size: 1.25rem;
        }
        .logo {
            height: 100px;
            width: auto;
            object-fit: contain;
            display: block;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 20px;
            max-width: 100%;
            max-height: 100px;
        }
        .waiting-count {
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 d-flex flex-column">
        <!-- Header with clinic info -->
        <div class="row py-3">
            <div class="col-12 text-center">
                <div class="clinic-info">
                    <img src="{{ asset('https://www.suncitypolyclinicsa.com/public/media/uploads/logo-favicon/173183818125.png') }}" alt="Clinic Logo" class="logo">
                    <h2 class="mt-3">Sun City's Polyclinic & Family Clinic</h2>
                </div>
            </div>
        </div>

        <!-- Queue display section -->
        <div class="row flex-grow-1 mb-4">
            <!-- Priority Queue Card -->
            <div class="col-md-6 mb-4">
                <div class="queue-card">
                    <div class="priority-header p-3">
                        <h3 class="mb-0">Priority Token</h3>
                    </div>
                    <div class="card-body text-center py-4">
                        <div id="priority-ticket" class="ticket-display priority-ticket mb-3">---</div>
                        <div class="mb-3">
                            <h4 id="priority-department" class="text-danger"></h4>
                            <h4 id="priority-doctor" class="text-danger"></h4>
                        </div>
                        <div id="priority-waiting" class="waiting-count text-danger mt-3"></div>
                    </div>
                </div>
            </div>

            <!-- Regular Queue Card -->
            <div class="col-md-6 mb-4">
                <div class="queue-card">
                    <div class="regular-header p-3">
                        <h3 class="mb-0">Regular Token</h3>
                    </div>
                    <div class="card-body text-center py-4">
                        <div id="regular-ticket" class="ticket-display regular-ticket mb-3">---</div>
                        <div class="mb-3">
                            <h4 id="regular-department" class="text-primary"></h4>
                            <h4 id="regular-doctor" class="text-primary"></h4>
                        </div>
                        <div id="regular-waiting" class="waiting-count text-primary mt-3"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 text-center">
                <div class="text-muted">
                    <p class="h5">Please wait for your token number to be called</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateDisplay() {
            fetch('/monitor/current-ticket')
                .then(response => response.json())
                .then(data => {
                    // Update priority ticket display
                    const priorityTicketDisplay = document.getElementById('priority-ticket');
                    const priorityDeptDisplay = document.getElementById('priority-department');
                    const priorityDoctorDisplay = document.getElementById('priority-doctor');
                    const priorityWaitingDisplay = document.getElementById('priority-waiting');
                    
                    if (data.priority_ticket_number) {
                        priorityTicketDisplay.textContent = data.priority_ticket_number;
                        priorityDeptDisplay.textContent = `Department: ${data.priority_department}`;
                        priorityDoctorDisplay.textContent = `Doctor: Dr. ${data.priority_doctor}`;
                        
                        if (data.priority_waiting_count > 0) {
                            priorityWaitingDisplay.textContent = `Waiting: ${data.priority_waiting_count}`;
                        } else {
                            priorityWaitingDisplay.textContent = '';
                        }
                    } else {
                        priorityTicketDisplay.textContent = '---';
                        priorityDeptDisplay.textContent = '';
                        priorityDoctorDisplay.textContent = '';
                        priorityWaitingDisplay.textContent = '';
                    }
                    
                    // Update regular ticket display
                    const regularTicketDisplay = document.getElementById('regular-ticket');
                    const regularDeptDisplay = document.getElementById('regular-department');
                    const regularDoctorDisplay = document.getElementById('regular-doctor');
                    const regularWaitingDisplay = document.getElementById('regular-waiting');

                    if (data.regular_ticket_number) {
                        regularTicketDisplay.textContent = data.regular_ticket_number;
                        regularDeptDisplay.textContent = `Department: ${data.regular_department}`;
                        regularDoctorDisplay.textContent = `Doctor: Dr. ${data.regular_doctor}`;
                        
                        if (data.regular_waiting_count > 0) {
                            regularWaitingDisplay.textContent = `Waiting: ${data.regular_waiting_count}`;
                        } else {
                            regularWaitingDisplay.textContent = '';
                        }
                    } else {
                        regularTicketDisplay.textContent = '---';
                        regularDeptDisplay.textContent = '';
                        regularDoctorDisplay.textContent = '';
                        regularWaitingDisplay.textContent = '';
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        // Update every 2 seconds
        setInterval(updateDisplay, 2000);
        updateDisplay(); // Initial call
    </script>
</body>
</html>