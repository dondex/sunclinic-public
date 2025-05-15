@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center mb-4">
        <div class="col-12 text-center">
            <img src="{{ asset('media/uploads/logo-favicon/173183818125.png') }}" alt="Sun City's" class="img-fluid" style="max-height: 60px;">
            <h2 class="mt-2">Regular Queue - Sun City's Polyclinic</h2>
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
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Regular Token Number</h6>
                    <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Main Queue
                    </a>
                </div>
                <div class="card-body text-center py-5">
                    @if($currentRegularTicket)
                    <h1 class="display-1 text-primary mb-4">{{ $currentRegularTicket->ticket_number }}</h1>
                    <div class="mb-4">
                        <h5 class="text-primary">Department: {{ $currentRegularTicket->department->name }}</h5>
                        <h5 class="text-primary">Dr. {{ $currentRegularTicket->doctor->name }}</h5>
                    </div>
                    <div class="text-muted mb-2">Patients Ahead: {{ $waitingCount }}</div>
                    <div class="text-muted mb-4">Estimated waiting time: {{ $waitingCount * 15 }} minutes</div>

                    <div class="d-flex justify-content-center mb-3">
                        <button type="button" class="btn btn-secondary me-2 regular-previous-btn" data-ticket-id="{{ $currentRegularTicket->id }}">
                            Previous
                        </button>
                        <button type="button" class="btn btn-primary regular-next-btn" data-ticket-id="{{ $currentRegularTicket->id }}">
                            Next
                        </button>
                    </div>
                    @else
                    <h1 class="display-3 text-muted">No active regular ticket</h1>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn btn-primary regular-next-btn" data-ticket-id="0">
                            Start Regular Queue
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Upcoming Regular Tickets</h6>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($regularTickets as $index => $ticket)
                            <tr class="{{ ($currentRegularTicket && $ticket->id === $currentRegularTicket->id) ? 'table-primary' : '' }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $ticket->ticket_number }}</td>
                                <td>{{ $ticket->department->name }}</td>
                                <td>Dr. {{ $ticket->doctor->name }}</td>
                                <td>
                                    @if($currentRegularTicket && $ticket->id === $currentRegularTicket->id)
                                        <span class="badge bg-success">Processing</span>
                                    @elseif($ticket->status === 'completed')
                                        <span class="badge bg-secondary">Completed</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Waiting</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach

                            @if(count($regularTickets) == 0)
                            <tr>
                                <td colspan="5" class="text-center py-3">No regular tickets</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.regular-next-btn').click(function() {
        const ticketId = $(this).data('ticket-id') || 0;
        $.ajax({
            url: "{{ route('admin.tickets.regular-next') }}",
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
                    alert('No more regular tickets in queue');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });

    $('.regular-previous-btn').click(function() {
        const ticketId = $(this).data('ticket-id') || 0;
        $.ajax({
            url: "{{ route('admin.tickets.regular-previous') }}",
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
                    alert('No previous regular tickets available');
                } else {
                    alert('An error occurred. Please try again.');
                }
            }
        });
    });
});
</script>
@endsection