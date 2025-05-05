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
            font-size: 12rem;
            font-weight: bold;
            color: #dc3545;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .clinic-info {
            font-size: 2rem;
            color: #343a40;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .text-muted {
            font-size: 1.25rem;
        }
        .logo {
            height: 100px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
        <div class="text-center">
            <div class="clinic-info mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Clinic Logo" class="logo">
                <h1 class="mt-3">Sun City's Polyclinic & Family Clinic</h1>
            </div>

            <div class="card p-5 mb-4">
                <h2 class="mb-4">Current Token Number</h2>
                <div id="current-ticket" class="ticket-display">---</div>
                <div class="mt-4">
                    <h3 id="department-info" class="text-secondary"></h3>
                    <h3 id="doctor-info" class="text-secondary"></h3>
                </div>
            </div>

            <div class="text-muted mt-4">
                <p class="h5">Please wait for your number to be called</p>
            </div>
        </div>
    </div>

    <script>
        function updateDisplay() {
            fetch('/monitor/current-ticket')
                .then(response => response.json())
                .then(data => {
                    const ticketDisplay = document.getElementById('current-ticket');
                    const deptDisplay = document.getElementById('department-info');
                    const doctorDisplay = document.getElementById('doctor-info');

                    if (data.ticket_number) {
                        ticketDisplay.textContent = data.ticket_number;
                        deptDisplay.textContent = `Department: ${data.department}`;
                        doctorDisplay.textContent = `Doctor: Dr. ${data.doctor}`;
                    } else {
                        ticketDisplay.textContent = '---';
                        deptDisplay.textContent = '';
                        doctorDisplay.textContent = '';
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
