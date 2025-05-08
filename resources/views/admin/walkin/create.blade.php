@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2"></i>Walk-in Registration
        </h1>
        <a href="{{ url('admin/dashboard') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-gradient-light">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list mr-1"></i> New Walk-in Patient
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                    aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Quick Actions:</div>
                    <a class="dropdown-item" href="{{ url('admin/tickets') }}"><i class="fas fa-ticket-alt mr-2"></i>View All Tickets</a>
                    <a class="dropdown-item" href="{{ url('admin/patients') }}"><i class="fas fa-users mr-2"></i>View All Patients</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger border-left-danger shadow-sm">
                    <h6 class="font-weight-bold"><i class="fas fa-exclamation-circle mr-1"></i>Please correct the following errors:</h6>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.walkin.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-4 border-left-info shadow-sm">
                            <div class="card-header py-3 bg-light">
                                <h6 class="m-0 font-weight-bold text-info">
                                    <i class="fas fa-user mr-1"></i> Patient Information
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="name" class="font-weight-bold text-dark">Patient Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                        <div class="invalid-feedback">Please enter the patient name.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="resident_number" class="font-weight-bold text-dark">Resident Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control form-control-lg" id="resident_number" name="resident_number" value="{{ old('resident_number') }}" placeholder="Enter resident number" required>
                                        <div class="invalid-feedback">Please enter a resident number.</div>
                                        <small class="form-text text-muted">Unique identifier used in the system.</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="password" class="font-weight-bold text-dark">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="Create a password" required>
                                        <div class="invalid-feedback">Please create a password (minimum 6 characters).</div>
                                        <small class="form-text text-muted">Password must be at least 6 characters long.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="card mb-4 border-left-primary shadow-sm">
                            <div class="card-header py-3 bg-light">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-hospital-user mr-1"></i> Appointment Details
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="department_id" class="font-weight-bold text-dark">Department <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-lg" id="department_id" name="department_id" required>
                                            <option value="">Select Department</option>
                                            @foreach ($departments as $department)
                                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Please select a department.</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="doctor_id" class="font-weight-bold text-dark">Doctor <span class="text-danger">*</span></label>
                                        <select class="form-control form-control-lg" id="doctor_id" name="doctor_id" required>
                                            <option value="">Select Department First</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a doctor.</div>
                                        <div id="loadingDoctors" class="mt-2 d-none">
                                            <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                            <span class="ml-1 text-primary">Loading doctors...</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mt-3" role="alert">
                                    <i class="fas fa-info-circle mr-1"></i> After registration, a ticket will be generated for the patient.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-left-success shadow-sm">
                            <div class="card-body py-3">
                                <div class="d-flex flex-row justify-content-between align-items-center">
                                    <div>
                                        <small class="text-muted">
                                            <i class="fas fa-asterisk text-danger mr-1"></i> Required fields
                                        </small>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-success btn-lg px-5 shadow-sm">
                                            <i class="fas fa-ticket-alt mr-1"></i> Register & Generate Ticket
                                        </button>
                                        <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary btn-lg ml-2 px-4 shadow-sm">
                                            <i class="fas fa-times mr-1"></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all forms we want to apply validation to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Load doctors when department is selected
        $('#department_id').change(function() {
            var departmentId = $(this).val();
            if(departmentId) {
                $('#loadingDoctors').removeClass('d-none');
                $.ajax({
                    url: '{{ route("admin.walkin.doctors") }}',
                    type: 'GET',
                    data: {department_id: departmentId},
                    success: function(data) {
                        $('#doctor_id').empty();
                        $('#doctor_id').append('<option value="">Select Doctor</option>');
                        $.each(data, function(key, value) {
                            $('#doctor_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        $('#loadingDoctors').addClass('d-none');
                    },
                    error: function() {
                        $('#loadingDoctors').addClass('d-none');
                        $('#doctor_id').empty();
                        $('#doctor_id').append('<option value="">Error loading doctors</option>');
                    }
                });
            } else {
                $('#doctor_id').empty();
                $('#doctor_id').append('<option value="">Select Department First</option>');
            }
        });
    });
</script>
@endsection
