@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mt-3">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-ticket-alt text-primary mr-2"></i>Walk-in Ticket</h1>
        <div>
            <a href="{{ route('admin.walkin.create') }}" class="btn btn-success shadow-sm mr-2 px-3 py-2">
                <i class="fas fa-plus-circle mr-2"></i> New Walk-in
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary shadow-sm px-3 py-2">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Alert container for notifications -->
            <div class="alert-container">
                @if(session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>
            
            <div class="card shadow-lg" id="ticket-container" data-ticket-id="{{ $ticket->id }}">
                <div class="card-header bg-gradient-primary text-white text-center py-3">
                    <img src="{{ asset('uploads/sunclinic.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 80px;">
                    <h3 class="mt-2 font-weight-bold">Sun City's Polyclinic & Family Clinic</h3>
                </div>
                
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="row w-100">
                        <div class="col-12 text-center">
                            <div class="ticket-container">
                                <h4 class="mb-4 text-primary"><i class="fas fa-hashtag mr-2"></i>Token Number</h4>
                                <div class="ticket-number">
                                    <h1 class="text-danger font-weight-bold">{{ $ticket->ticket_number }}</h1>
                                </div>
                                <div class="ticket-details px-3 py-4 border-top border-bottom">
                                    <div class="row mb-2">
                                        <div class="col-1 text-center">
                                            <i class="fas fa-hospital text-primary"></i>
                                        </div>
                                        <div class="col-11 text-left">
                                            <h5 class="font-weight-bold text-primary">Department: <span class="text-dark">{{ $ticket->department->name }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-1 text-center">
                                            <i class="fas fa-user-md text-primary"></i>
                                        </div>
                                        <div class="col-11 text-left">
                                            <h5 class="font-weight-bold text-primary">Doctor: <span class="text-dark">Dr. {{ $ticket->doctor->name }}</span></h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-1 text-center">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div class="col-11 text-left">
                                            <h5 class="font-weight-bold text-primary">Patient: <span class="text-dark">{{ $ticket->patient->name }}</span></h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="ticket-status mt-4">
                                    @if($ticket->status === 'processing')
                                        <span class="badge badge-pill badge-success px-4 py-2 text-white"><i class="fas fa-spinner fa-spin mr-2"></i>Now Processing</span>
                                    @elseif($ticket->status === 'completed')
                                        <span class="badge badge-pill badge-secondary px-4 py-2 text-white"><i class="fas fa-check-circle mr-2"></i>Completed</span>
                                    @else
                                        <span class="badge badge-pill badge-warning px-4 py-2 text-dark"><i class="fas fa-clock mr-2"></i>Waiting</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Priority Lane (if applicable) -->
                        @if($ticket->priority == 'priority')
                        <div class="col-md-12 text-center mt-3 bg-warning-subtle py-3 border-top border-warning">
                            <div class="priority-section">
                                <h4 class="text-warning mt-2"><i class="fas fa-star mr-2"></i>Priority Lane</h4>
                                <h5 class="text-warning mt-2 mb-3">This patient has priority status</h5>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <div class="card-footer text-center bg-light py-3">
                    <h5 class="mb-1 font-weight-bold"><i class="fas fa-hospital-alt mr-2 text-primary"></i>Welcome to Sun City Hospital</h5>
                    <p class="mb-0 text-muted">{{ now()->format('F d, Y h:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add notification sound -->
<audio id="notification-sound" src="{{ asset('assets/sounds/notification.mp3') }}" preload="auto"></audio>

<style>
    .card-body {
        min-height: 450px;
        padding: 0;
    }
    .ticket-container {
        padding: 30px 20px;
    }
    .ticket-number h1 {
        font-size: 6rem;
        margin: 20px 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    .ticket-details {
        margin: 25px 0;
        background-color: rgba(245, 247, 250, 0.7);
        border-radius: 8px;
    }
    .bg-warning-subtle {
        background-color: #fff8e1;
    }
    .bg-gradient-primary {
        background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
    }
    .badge-pill {
        font-size: 1rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .badge-success {
        background-color: #1cc88a;
        color: #fff !important;
    }
    .badge-warning {
        background-color: #f6c23e;
        color: #212529 !important;
    }
    .badge-secondary {
        background-color: #858796;
        color: #fff !important;
    }
    .shadow-lg {
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
    .btn {
        border-radius: 5px;
        font-weight: 500;
        letter-spacing: 0.3px;
    }
    @media print {
        .btn, .alert, .navbar, .sidebar, .page-heading, .no-print {
            display: none !important;
        }
        .card {
            border: none;
            width: 100%;
            max-width: 100%;
            box-shadow: none !important;
        }
        .card-header, .card-body, .card-footer {
            padding: 10px;
        }
        .bg-gradient-primary {
            background: #4e73df !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        body {
            padding: 0;
            margin: 0;
            background: none;
        }
        .container-fluid {
            padding: 0;
            margin: 0;
        }
        .content-wrapper {
            padding: 0 !important;
            margin: 0 !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Add print functionality to ticket
        $('.ticket-container').dblclick(function() {
            window.print();
        });
        
        // Check for status changes with real-time updates
        function checkTicketStatus() {
            var ticketId = $('#ticket-container').data('ticket-id');
            
            $.ajax({
                url: '/admin/walkin/check-status/' + ticketId,
                type: 'GET',
                success: function(response) {
                    if (response.status !== '{{ $ticket->status }}') {
                        // Update status display
                        $('.ticket-status').html('');
                        
                        if (response.status === 'processing') {
                            $('.ticket-status').html('<span class="badge badge-pill badge-success px-4 py-2 text-white"><i class="fas fa-spinner fa-spin mr-2"></i>Now Processing</span>');
                            // Play notification sound
                            $('#notification-sound')[0].play();
                        } else if (response.status === 'completed') {
                            $('.ticket-status').html('<span class="badge badge-pill badge-secondary px-4 py-2 text-white"><i class="fas fa-check-circle mr-2"></i>Completed</span>');
                        } else {
                            $('.ticket-status').html('<span class="badge badge-pill badge-warning px-4 py-2 text-dark"><i class="fas fa-clock mr-2"></i>Waiting</span>');
                        }
                    }
                }
            });
        }
        
        // Check status every 15 seconds
        setInterval(checkTicketStatus, 15000);
        
        // Add a tooltip to hint about print functionality
        $('.ticket-container').attr('title', 'Double-click to print');
        
        // Highlight current ticket on page load with subtle animation
        $('.ticket-number h1').addClass('animate__animated animate__pulse');
        
        // Optional: Add a "Copy to clipboard" functionality for the ticket number
        $('.ticket-number h1').click(function() {
            var ticketNumber = $(this).text();
            navigator.clipboard.writeText(ticketNumber).then(function() {
                // Show a temporary "Copied" tooltip
                $('<div class="copy-alert">Ticket number copied!</div>')
                    .appendTo('body')
                    .fadeIn(200)
                    .delay(1000)
                    .fadeOut(200, function() { $(this).remove(); });
            });
        });
        
        // Add floating hints for interactive elements
        $('.ticket-number h1').hover(
            function() { $(this).attr('title', 'Click to copy ticket number'); },
            function() { $(this).removeAttr('title'); }
        );
    });
</script>
<style>
    .copy-alert {
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #4e73df;
        color: white;
        padding: 10px 15px;
        border-radius: 4px;
        z-index: 9999;
        display: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .animate__animated.animate__pulse {
        animation-duration: 1.5s;
        animation-iteration-count: 2;
    }
    @keyframes pulse {
        from { transform: scale3d(1, 1, 1); }
        50% { transform: scale3d(1.05, 1.05, 1.05); }
        to { transform: scale3d(1, 1, 1); }
    }
    .animate__pulse {
        animation-name: pulse;
        animation-timing-function: ease-in-out;
    }
    .ticket-number h1 {
        cursor: pointer;
        transition: transform 0.2s ease;
    }
    .ticket-number h1:hover {
        transform: scale(1.03);
    }
    .btn:hover {
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>
@endsection