@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center mb-4">
        <div class="col-12 text-center">
            <img src="{{ asset('https://www.suncitypolyclinicsa.com/public/media/uploads/logo-favicon/173183818125.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 60px;">
            <h2 class="mt-2">Sun City's Polyclinic & Family Clinic</h2>
        </div>
    </div>

    @if(session('success'))
    <div class="row justify-content-center mb-3">
        <div class="col-md-8">
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Token Display (Center) -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Token Number</h6>
                    <div>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary me-2">
                            <i class="fas fa-arrow-left me-1"></i> Return to Dashboard
                        </a>
                        <a href="{{ route('admin.tickets.restart') }}"
                           class="btn btn-sm btn-warning"
                           onclick="return confirm('Are you sure you want to restart the queue? All processed tickets will be reset.')">
                            <i class="fas fa-sync-alt me-1"></i> Restart Queue
                        </a>
                    </div>
                </div>
                <div class="card-body text-center py-5">
                    @if($currentTicket)
                    <h1 class="display-1 text-danger mb-4">{{ $currentTicket->ticket_number }}</h1>
                    <div class="mb-4">
                        <h5 class="text-danger">Department: {{ $currentTicket->department->name }}</h5>
                        <h5 class="text-danger">Dr. {{ $currentTicket->doctor->name }}</h5>
                    </div>
                    <div class="text-muted mb-2">People ahead of you: {{ $waitingCount }}</div>
                    <div class="text-muted mb-4">Estimated waiting time: {{ $waitingCount * 15 }} minutes</div>

                    <!-- Control Buttons Below Token Number -->
                    <div class="d-flex justify-content-center mb-3">
                        <button type="button" class="btn btn-secondary me-2 previous-btn" data-ticket-id="{{ $currentTicket->id }}">
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary next-btn" data-ticket-id="{{ $currentTicket->id }}">
                            Next
                        </button>
                    </div>
                    @else
                    <h1 class="display-3 text-muted">No active ticket</h1>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn btn-primary next-btn">
                            Start Queue
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Queue List Below -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Current Queue</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Ticket #</th>
                                <th>Department</th>
                                <th>Doctor</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tickets as $index => $ticket)
                            <tr class="{{ ($currentTicket && $ticket->id === $currentTicket->id) ? 'table-primary' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->department->name }}</td>
                                <td>Dr. {{ $ticket->doctor->name }}</td>
                                <td>
                                    @if($currentTicket && $ticket->id === $currentTicket->id)
                                        <span class="badge bg-success">Processing</span>
                                    @elseif($ticket->status === 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->status !== 'processing')
                                    <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Show
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Previously Processed Tickets -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Previously Processed Tickets</h6>
                </div>
                <div class="card-body p-0">
                    @if($completedTickets->count() > 0)
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Ticket #</th>
                                <th>Department</th>
                                <th>Doctor</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($completedTickets as $ticket)
                            <tr>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->department->name }}</td>
                                <td>Dr. {{ $ticket->doctor->name }}</td>
                                <td>
                                    <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Show Again
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="p-4 text-center text-muted">
                        No processed tickets yet
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Next Button
    $('.next-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: "{{ route('admin.tickets.next') }}",
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                current_ticket_id: ticketId || 0
            },
            success: function(response) {
                window.location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    alert('No more tickets in queue');
                }
            }
        });
    });

    // Previous Button
    $('.previous-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: "{{ route('admin.tickets.previous') }}",
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                current_ticket_id: ticketId
            },
            success: function(response) {
                window.location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    alert('No previous tickets available');
                }
            }
        });
    });
});
</script>
@endsection
