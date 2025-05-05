@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Queue List -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    Current Queue
                </div>
                <div class="card-body">
                    @foreach($queue as $q)
                    <div class="alert @if($q->id == $ticket->id) alert-primary @else alert-secondary @endif">
                        <h5>{{ $q->ticket_number }}</h5>
                        <p class="mb-0">{{ $q->department->name }} - Dr. {{ $q->doctor->name }}</p>
                        <small>Status: {{ ucfirst($q->status) }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Current Ticket Controls -->
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Ticket</h6>
                    <div>
                        <span class="badge badge-{{ $ticket->priority == 'priority' ? 'danger' : 'info' }}">
                            {{ ucfirst($ticket->priority) }}
                        </span>
                    </div>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-4 mb-4">{{ $ticket->ticket_number }}</h1>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <p class="text-muted mb-0">Department</p>
                            <h4>{{ $ticket->department->name }}</h4>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-0">Doctor</p>
                            <h4>Dr. {{ $ticket->doctor->name }}</h4>
                        </div>
                        <div class="col-md-4">
                            <p class="text-muted mb-0">Patient</p>
                            <h4>{{ $ticket->patient->name }}</h4>
                        </div>
                    </div>
                    
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.tickets.previous', $ticket->id) }}" 
                           class="btn btn-lg btn-secondary">
                           ← Previous
                        </a>
                        <a href="{{ route('admin.tickets.next', $ticket->id) }}" 
                           class="btn btn-lg btn-primary">
                           Next →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection