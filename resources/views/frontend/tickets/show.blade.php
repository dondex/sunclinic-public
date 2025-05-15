@extends('layouts.app')

@section('head')
<meta http-equiv="refresh" content="300"> <!-- Fallback refresh every 5 minutes -->
@endsection

@section('content')
<div class="container">
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
            
            <div class="card" id="ticket-container" 
                 data-ticket-id="{{ $ticket->id }}"
                 data-initial-status="{{ $ticket->status }}">
                <div class="card-header text-center">
                    <img src="{{ asset('uploads/sunclinic.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 80px;">
                    <h3 class="mt-2">Sun City's Polyclinic & Family Clinic</h3>
                </div>
                
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div class="row w-100">
                        <div class="col-12 text-center">
                            <div class="ticket-container">
                                <h4 class="mb-4">Token Number</h4>
                                <div class="ticket-number">
                                    <h1 class="text-danger font-weight-bold">{{ $ticket->ticket_number }}</h1>
                                </div>
                                <div class="ticket-details">
                                    <h5 class="text-danger">Department {{ $ticket->department->name }}</h5>
                                    <h5 class="text-danger">Dr. {{ $ticket->doctor->name }}</h5>
                                </div>
                                <div class="ticket-status mt-3">
                                    @if($ticket->status === 'processing')
                                        <span class="badge bg-success">Now Processing</span>
                                    @elseif($ticket->status === 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Priority Lane  -->
                        <div class="col-md-12 text-center mt-3 {{ $ticket->priority == 'priority' || $priorityTicket ? 'bg-warning-subtle' : 'd-none' }}">
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
        </div>
    </div>
</div>

<style>
    .card-body {
        min-height: 400px;
        padding: 0;
    }
    .ticket-container {
        padding: 40px 20px;
    }
    .ticket-number h1 {
        font-size: 6rem;
        margin: 30px 0;
    }
    .ticket-details {
        margin-top: 30px;
    }
    .ticket-status .badge {
        font-size: 2rem;
        padding: 12px 24px;
        display: inline-block;
    }
    .bg-warning-subtle {
        background-color: #fff8e1;
    }
    .bg-success-subtle {
        background-color: #d4edda;
        transition: background-color 0.3s ease;
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

@section('scripts')
<script src="{{ asset('js/ticket-status.js') }}?v={{ time() }}"></script>
@endsection
