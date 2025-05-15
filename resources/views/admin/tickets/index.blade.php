@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center mb-4">
        <div class="col-12 text-center">
            <img src="{{ asset('https://www.suncitypolyclinicsa.com/public/media/uploads/logo-favicon/173183818125.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 60px;">
            <h2 class="mt-2">Sun City's Polyclinic & Family Clinic</h2>
        </div>
    </div>

    <!-- Action Buttons Moved Outside -->
    <div class="row justify-content-center mb-4">
        <div class="col-md-11 text-end">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary me-2">
                Dashboard
            </a>
            <a href="{{ route('admin.tickets.restart') }}"
               class="btn btn-warning"
               onclick="return confirm('Are you sure you want to restart the queue? All processed tickets will be reset.')">
                Restart Queue
            </a>
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

    <!-- Modified Mini-Monitor Layout Based on Reference Image -->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row g-4">
                <!-- Left Section: Priority Queue -->
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-danger text-white">
                            <h6 class="m-0 font-weight-bold">Priority Token Number</h6>
                        </div>
                        <div class="card-body text-center py-5">
                            @if($priorityCurrent)
                            <h1 class="display-1 text-danger mb-4" style="font-size: 5rem;">{{ $priorityCurrent->ticket_number }}</h1>
                            <div class="mb-4">
                                <p class="text-danger mb-1">Department: {{ $priorityCurrent->department->name }}</p>
                                <p class="text-danger">Dr. {{ $priorityCurrent->doctor->name }}</p>
                            </div>

                            <div class="text-muted mb-4">Priority Queue</div>

                            <div class="d-flex justify-content-center mb-3">
                                <button type="button" class="btn btn-secondary me-2 previous-priority-btn" data-ticket-id="{{ $priorityCurrent->id }}">
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next-priority-btn" data-ticket-id="{{ $priorityCurrent->id }}">
                                    Next
                                </button>
                            </div>
                            @else
                            <h1 class="display-3 text-muted">No active priority ticket</h1>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-primary next-priority-btn" data-ticket-id="0">
                                    Start Priority Queue
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Section: Regular Queue -->
                <div class="col-md-6">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
                            <h6 class="m-0 font-weight-bold">Regular Token Number</h6>
                        </div>
                        <div class="card-body text-center py-5">
                            @if($regularCurrent)
                            <h1 class="display-1 text-primary mb-4" style="font-size: 5rem;">{{ $regularCurrent->ticket_number }}</h1>
                            <div class="mb-4">
                                <p class="text-primary mb-1">Department: {{ $regularCurrent->department->name }}</p>
                                <p class="text-primary">Dr. {{ $regularCurrent->doctor->name }}</p>
                            </div>

                            <div class="text-muted mb-4">Regular Queue</div>

                            <div class="d-flex justify-content-center mb-3">
                                <button type="button" class="btn btn-secondary me-2 previous-regular-btn" data-ticket-id="{{ $regularCurrent->id }}">
                                    Previous
                                </button>
                                <button type="button" class="btn btn-primary next-regular-btn" data-ticket-id="{{ $regularCurrent->id }}">
                                    Next
                                </button>
                            </div>
                            @else
                            <h1 class="display-3 text-muted">No active regular ticket</h1>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-primary next-regular-btn" data-ticket-id="0">
                                    Start Regular Queue
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Regular Queue List -->
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
                            @foreach($regularTickets as $index => $ticket)
                            <tr class="{{ ($regularCurrent && $ticket->id === $regularCurrent->id) ? 'table-primary' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->department->name }}</td>
                                <td>Dr. {{ $ticket->doctor->name }}</td>
                                <td>
                                    @if($regularCurrent && $ticket->id === $regularCurrent->id)
                                        <span class="badge bg-success">Processing</span>
                                    @elseif($ticket->status === 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->status !== 'processing')
                                        <button class="btn btn-sm btn-outline-danger priority-btn" data-ticket-id="{{ $ticket->id }}">
                                            Priority
                                        </button>
                                        <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                            Show
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if(count($regularTickets) == 0)
                            <tr>
                                <td colspan="6" class="text-center py-3">No regular tickets</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Priority Queue List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Priority Queue</h6>
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
                            @foreach($priorityTickets as $index => $ticket)
                            <tr class="{{ ($priorityCurrent && $ticket->id === $priorityCurrent->id) ? 'table-danger' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->department->name }}</td>
                                <td>Dr. {{ $ticket->doctor->name }}</td>
                                <td>
                                    @if($priorityCurrent && $ticket->id === $priorityCurrent->id)
                                        <span class="badge bg-success">Processing</span>
                                    @elseif($ticket->status === 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->status !== 'processing')
                                    <button class="btn btn-sm btn-outline-danger remove-priority-btn" data-ticket-id="{{ $ticket->id }}">
                                        Remove Priority
                                    </button>
                                    <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                        Show
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if(count($priorityTickets) == 0)
                            <tr>
                                <td colspan="6" class="text-center py-3">No priority tickets</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Completed Tickets -->
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
                                <th>Type</th>
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
                                    @if($ticket->is_priority)
                                    <span class="badge bg-danger">Priority</span>
                                    @else
                                    <span class="badge bg-primary">Regular</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
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
    // Regular Queue Navigation
    $('.next-regular-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: "{{ route('admin.tickets.regular-next') }}",
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                current_ticket_id: ticketId
            },
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    alert('No more tickets in regular queue');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    $('.previous-regular-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: "{{ route('admin.tickets.regular-previous') }}",
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                current_ticket_id: ticketId
            },
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    alert('No previous tickets available in regular queue');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    // Priority Queue Navigation
    $('.next-priority-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: "{{ route('admin.tickets.priority-next') }}",
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                current_ticket_id: ticketId
            },
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    alert('No more tickets in priority queue');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    $('.previous-priority-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: "{{ route('admin.tickets.priority-previous') }}",
            method: 'PUT',
            data: {
                _token: "{{ csrf_token() }}",
                current_ticket_id: ticketId
            },
            success: function() {
                window.location.reload();
            },
            error: function(xhr) {
                if (xhr.status === 404) {
                    alert('No previous tickets available in priority queue');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    // Priority management
    $('.priority-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: `/admin/tickets/prioritize/${ticketId}`,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                window.location.reload();
            },
            error: function() {
                alert('Failed to prioritize ticket.');
            }
        });
    });

    $('.remove-priority-btn').click(function() {
        const ticketId = $(this).data('ticket-id');
        $.ajax({
            url: `/admin/tickets/remove-priority/${ticketId}`,
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function() {
                window.location.reload();
            },
            error: function() {
                alert('Failed to remove ticket from priority.');
            }
        });
    });
});
</script>
@endsection