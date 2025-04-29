@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center mb-4">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 100px;">
            <h1 class="mt-2">Sun City's Polyclinic & Family Clinic</h1>
            <h2>Current Queue Status</h2>
        </div>
    </div>
    
    <div class="row">
        <!-- Regular Queue -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h3>Regular Queue</h3>
                </div>
                <div class="card-body">
                    @if(count($regularTickets) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Department</th>
                                        <th>Doctor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regularTickets as $ticket)
                                    <tr>
                                        <td><strong>{{ $ticket->ticket_number }}</strong></td>
                                        <td>{{ $ticket->department->name }}</td>
                                        <td>Dr. {{ $ticket->doctor->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No tickets in regular queue.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Priority Queue -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-warning text-dark text-center">
                    <h3>Priority Queue</h3>
                </div>
                <div class="card-body">
                    @if(count($priorityTickets) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Department</th>
                                        <th>Doctor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($priorityTickets as $ticket)
                                    <tr>
                                        <td><strong>{{ $ticket->ticket_number }}</strong></td>
                                        <td>{{ $ticket->department->name }}</td>
                                        <td>Dr. {{ $ticket->doctor->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No tickets in priority queue.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Currently Processing -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white text-center">
                    <h3>Now Serving</h3>
                </div>
                <div class="card-body">
                    @if(count($processingTickets) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Ticket</th>
                                        <th>Department</th>
                                        <th>Doctor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($processingTickets as $ticket)
                                    <tr>
                                        <td><strong>{{ $ticket->ticket_number }}</strong></td>
                                        <td>{{ $ticket->department->name }}</td>
                                        <td>Dr. {{ $ticket->doctor->name }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No tickets currently being processed.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12 text-center">
            <h4>Last Updated: {{ now()->format('F j, Y h:i:s A') }}</h4>
            <p class="text-muted">This page refreshes automatically every 30 seconds</p>
        </div>
    </div>
</div>

<script>
    // Auto-refresh the page every 30 seconds
    setTimeout(function() {
        location.reload();
    }, 30000);
</script>
@endsection