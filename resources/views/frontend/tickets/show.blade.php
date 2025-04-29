@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            
            <div class="card">
                <div class="card-header text-center">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 80px;">
                    <h3 class="mt-2">Sun City's Polyclinic & Family Clinic</h3>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <!-- Left column: Current Queue -->
                        <div class="col-md-4 border-right">
                            <div class="queue-list">
                                <h5 class="mb-3">Current Queue</h5>
                                
                                @forelse($recentRegularTickets as $queueTicket)
                                <div class="ticket-item">
                                    <div class="d-flex justify-content-between">
                                        <span class="font-weight-bold">{{ $queueTicket->ticket_number }}</span>
                                        <span>{{ $queueTicket->department->name }}</span>
                                    </div>
                                    <small>Dr. {{ $queueTicket->doctor->name }}</small>
                                </div>
                                @empty
                                <div class="ticket-item">
                                    <p>No tickets in queue</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <!-- Middle column: Your Ticket -->
                        <div class="col-md-4 text-center">
                            <h4 class="mb-4">Token Number</h4>
                            <div class="ticket-number">
                                <h1 class="text-danger font-weight-bold" style="font-size: 3.5rem;">{{ $ticket->ticket_number }}</h1>
                            </div>
                            <div class="ticket-details mt-4 text-danger">
                                <h5>Department {{ $ticket->department->name }}</h5>
                                <h5>Dr. {{ $ticket->doctor->name }}</h5>
                            </div>
                            <div class="queue-info mt-4">
                                <p>People ahead of you: {{ $waitingTickets }}</p>
                                <p>Estimated waiting time: {{ $waitingTickets * 15 }} minutes</p>
                            </div>
                        </div>
                        
                        <!-- Right column: Priority Lane -->
                        <div class="col-md-4 text-center {{ $ticket->priority == 'priority' ? 'bg-warning-subtle' : '' }}">
                            @if($priorityTicket)
                            <div class="priority-section">
                                <h4 class="text-warning mt-3">Priority Lane</h4>
                                <h2 class="text-warning font-weight-bold" style="font-size: 3rem;">{{ $priorityTicket->ticket_number }}</h2>
                                <h5 class="text-warning mt-3">Department {{ $priorityTicket->department->name }}</h5>
                                <h5 class="text-warning">Dr. {{ $priorityTicket->doctor->name }}</h5>
                            </div>
                            @elseif($ticket->priority == 'priority')
                            <div class="priority-section">
                                <h4 class="text-warning mt-3">Priority Lane</h4>
                                <h2 class="text-warning font-weight-bold" style="font-size: 3rem;">{{ $ticket->ticket_number }}</h2>
                                <h5 class="text-warning mt-3">Department {{ $ticket->department->name }}</h5>
                                <h5 class="text-warning">Dr. {{ $ticket->doctor->name }}</h5>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="card-footer text-center">
                    <h5 class="mb-0">Welcome to Sun City Hospital</h5>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary" onclick="window.print()">Print Ticket</a>
                <a href="{{ route('home') }}" class="btn btn-secondary">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<style>
    .border-right {
        border-right: 1px solid #dee2e6;
    }
    .ticket-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .ticket-number {
        padding: 20px 0;
    }
    .bg-warning-subtle {
        background-color: #fff8e1;
    }
    @media print {
        .btn, .alert {
            display: none;
        }
        .card {
            border: none;
        }
        .card-header, .card-body, .card-footer {
            padding: 10px;
        }
    }
</style>
@endsection