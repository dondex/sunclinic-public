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

    <!-- Modified Mini-Monitor Layout Based on Reference Image -->
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="row g-4">
                <div class="d-flex justify-content-end mb-3">
                    <a href="{{ url('admin/dashboard') }}" class="btn btn-outline-dark d-flex align-items-center shadow-sm">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                 </div>
                 <!-- Left Section: Priority Queue -->
                <div class="col-lg-6 col-md-12">
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
                                    <i class="fas fa-arrow-left d-sm-none"></i>
                                    <span class="d-none d-sm-inline">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary next-priority-btn" data-ticket-id="{{ $priorityCurrent->id }}">
                                    <i class="fas fa-arrow-right d-sm-none"></i>
                                    <span class="d-none d-sm-inline">Next</span>
                                </button>
                            </div>
                            @else
                            <h1 class="display-3 text-muted">No active priority ticket</h1>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-primary next-priority-btn" data-ticket-id="0">
                                    <i class="fas fa-play d-sm-none"></i>
                                    <span class="d-none d-sm-inline">Start Priority Queue</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Section: Regular Queue -->
                <div class="col-lg-6 col-md-12">
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
                                    <i class="fas fa-arrow-left d-sm-none"></i>
                                    <span class="d-none d-sm-inline">Previous</span>
                                </button>
                                <button type="button" class="btn btn-primary next-regular-btn" data-ticket-id="{{ $regularCurrent->id }}">
                                    <i class="fas fa-arrow-right d-sm-none"></i>
                                    <span class="d-none d-sm-inline">Next</span>
                                </button>
                            </div>
                            @else
                            <h1 class="display-3 text-muted">No active regular ticket</h1>
                            <div class="d-flex justify-content-center mt-4">
                                <button type="button" class="btn btn-primary next-regular-btn" data-ticket-id="0">
                                    <i class="fas fa-play d-sm-none"></i>
                                    <span class="d-none d-sm-inline">Start Regular Queue</span>
                                </button>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- UPDATED: Redesigned Filter Section -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold">Filter Tickets</h6>
                    <button id="apply-filters-btn" class="btn btn-sm btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                </div>
                <div class="card-body py-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="department-filter" class="form-label fw-bold">Department</label>
                                <select id="department-filter" class="form-select">
                                    <option value="">All Departments</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="doctor-filter" class="form-label fw-bold">Doctor</label>
                                <select id="doctor-filter" class="form-select">
                                    <option value="">All Doctors</option>
                                    @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">Dr. {{ $doctor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
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
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="regular-queue-table">
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
                                <tr class="{{ ($regularCurrent && $ticket->id === $regularCurrent->id) ? 'table-primary' : '' }}" 
                                    data-department="{{ $ticket->department_id }}" 
                                    data-doctor="{{ $ticket->doctor_id }}" 
                                    data-ticket="{{ $ticket->ticket_number }}">
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
                                        <div class="d-flex flex-nowrap">
                                            @if($ticket->status !== 'processing')
                                                <button class="btn btn-sm btn-outline-danger priority-btn me-1" data-ticket-id="{{ $ticket->id }}">
                                                    <i class="fas fa-exclamation-circle d-md-none"></i>
                                                    <span class="d-none d-md-inline">Priority</span>
                                                </button>
                                                <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye d-md-none"></i>
                                                    <span class="d-none d-md-inline">Show</span>
                                                </a>
                                            @endif
                                        </div>
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
            </div>

            <!-- Priority Queue List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 font-weight-bold">Priority Queue</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="priority-queue-table">
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
                                <tr class="{{ ($priorityCurrent && $ticket->id === $priorityCurrent->id) ? 'table-danger' : '' }}"
                                    data-department="{{ $ticket->department_id }}" 
                                    data-doctor="{{ $ticket->doctor_id }}" 
                                    data-ticket="{{ $ticket->ticket_number }}">
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
                                        <div class="d-flex flex-nowrap">
                                            @if($ticket->status !== 'processing')
                                            <button class="btn btn-sm btn-outline-danger remove-priority-btn me-1" data-ticket-id="{{ $ticket->id }}">
                                                <i class="fas fa-minus-circle d-md-none"></i>
                                                <span class="d-none d-md-inline">Remove</span>
                                            </button>
                                            <a href="{{ route('admin.tickets.show-specific', $ticket->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye d-md-none"></i>
                                                <span class="d-none d-md-inline">Show</span>
                                            </a>
                                            @endif
                                        </div>
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
            </div>

            <!-- Completed Tickets -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">Previously Processed Tickets</h6>
                </div>
                <div class="card-body p-0">
                    @if($completedTickets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="completed-tickets-table">
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
                                <tr data-department="{{ $ticket->department_id }}" 
                                    data-doctor="{{ $ticket->doctor_id }}" 
                                    data-ticket="{{ $ticket->ticket_number }}">
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
                                            <i class="fas fa-eye d-md-none"></i>
                                            <span class="d-none d-md-inline">Show Again</span>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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

    // UPDATED: Filter functionality with apply button
    $('#apply-filters-btn').click(function() {
        applyFilters();
    });

    function applyFilters() {
        const departmentId = $('#department-filter').val();
        const doctorId = $('#doctor-filter').val();
        
        // Filter regular queue
        $("#regular-queue-table tbody tr").each(function() {
            const rowDeptId = $(this).data('department');
            const rowDoctorId = $(this).data('doctor');
            
            let showRow = true;
            
            if (departmentId && rowDeptId != departmentId) {
                showRow = false;
            }
            
            if (doctorId && rowDoctorId != doctorId) {
                showRow = false;
            }
            
            $(this).toggle(showRow);
        });
        
        // Filter priority queue
        $("#priority-queue-table tbody tr").each(function() {
            const rowDeptId = $(this).data('department');
            const rowDoctorId = $(this).data('doctor');
            
            let showRow = true;
            
            if (departmentId && rowDeptId != departmentId) {
                showRow = false;
            }
            
            if (doctorId && rowDoctorId != doctorId) {
                showRow = false;
            }
            
            $(this).toggle(showRow);
        });
        
        // Filter completed tickets
        $("#completed-tickets-table tbody tr").each(function() {
            const rowDeptId = $(this).data('department');
            const rowDoctorId = $(this).data('doctor');
            
            let showRow = true;
            
            if (departmentId && rowDeptId != departmentId) {
                showRow = false;
            }
            
            if (doctorId && rowDoctorId != doctorId) {
                showRow = false;
            }
            
            $(this).toggle(showRow);
        });
    }
});
</script>
@endsection