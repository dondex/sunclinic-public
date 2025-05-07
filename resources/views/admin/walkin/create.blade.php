@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus mr-2"></i>Add Walk-in Patient
        </h1>
        <a href="{{ url('admin/dashboard') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Dashboard
        </a>
    </div>

    <div class="card shadow mb-4 border-left-primary">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list mr-1"></i> Patient Registration Form
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Actions:</div>
                    <a class="dropdown-item" href="#"><i class="fas fa-print fa-sm fa-fw mr-2 text-gray-400"></i>Print Form</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>View All Patients</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger border-left-danger" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.walkin.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                
                <!-- Progress indicator -->
                <div class="progress mb-4" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">
                                <i class="fas fa-user mr-1 text-gray-500"></i> Patient Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg" id="name" name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                            <div class="invalid-feedback">Patient name is required</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="phone" class="font-weight-bold">
                                <i class="fas fa-phone mr-1 text-gray-500"></i> Phone Number <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-light">+</span>
                                </div>
                                <input type="tel" class="form-control form-control-lg" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter contact number" required>
                            </div>
                            <div class="invalid-feedback">Valid phone number is required</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">
                                <i class="fas fa-envelope mr-1 text-gray-500"></i> Email Address
                            </label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com">
                            <small class="text-muted">For appointment notifications (optional)</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="birth_date" class="font-weight-bold">
                                <i class="fas fa-calendar-alt mr-1 text-gray-500"></i> Date of Birth
                            </label>
                            <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                            <small class="text-muted">Used to calculate age</small>
                        </div>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="text-primary mb-3"><i class="fas fa-stethoscope mr-1"></i> Appointment Details</h5>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="department_id" class="font-weight-bold">
                                <i class="fas fa-hospital mr-1 text-gray-500"></i> Department <span class="text-danger">*</span>
                            </label>
                            <select class="form-control form-control-lg custom-select" id="department_id" name="department_id" required>
                                <option value="">Select Department</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Please select a department</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="doctor_id" class="font-weight-bold">
                                <i class="fas fa-user-md mr-1 text-gray-500"></i> Doctor <span class="text-danger">*</span>
                            </label>
                            <select class="form-control form-control-lg custom-select" id="doctor_id" name="doctor_id" required>
                                <option value="">Select Department First</option>
                            </select>
                            <div class="invalid-feedback">Please select a doctor</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="appointment_date" class="font-weight-bold">
                                <i class="fas fa-calendar mr-1 text-gray-500"></i> Appointment Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date', date('Y-m-d')) }}" required>
                            <div class="invalid-feedback">Please select an appointment date</div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <label for="appointment_time" class="font-weight-bold">
                                <i class="fas fa-clock mr-1 text-gray-500"></i> Appointment Time <span class="text-danger">*</span>
                            </label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                            <div class="invalid-feedback">Please select an appointment time</div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="form-group mb-0">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_priority" name="is_priority" {{ old('is_priority') ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold" for="is_priority">
                                            <i class="fas fa-star text-warning mr-1"></i> Priority Patient
                                        </label>
                                    </div>
                                    <small class="text-muted d-block mt-1">For senior citizens, PWDs, pregnant women, etc.</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-4" id="priority_reason_div" style="{{ old('is_priority') ? '' : 'display: none;' }}">
                        <div class="form-group">
                            <label for="priority_reason" class="font-weight-bold">
                                <i class="fas fa-info-circle mr-1 text-gray-500"></i> Priority Reason
                            </label>
                            <textarea class="form-control" id="priority_reason" name="priority_reason" rows="2" placeholder="Please specify priority reason">{{ old('priority_reason') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save mr-2"></i> Register Patient & Generate Ticket
                    </button>
                    <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary btn-lg px-5 ml-2">
                        <i class="fas fa-times mr-2"></i> Cancel
                    </a>
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
                var forms = document.getElementsByClassName('needs-validation');
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

        // Show/hide priority reason field with animation
        $('#is_priority').change(function() {
            if($(this).is(':checked')) {
                $('#priority_reason_div').slideDown(300);
            } else {
                $('#priority_reason_div').slideUp(300);
            }
        });

        // Load doctors when department is selected
        $('#department_id').change(function() {
            var departmentId = $(this).val();
            if(departmentId) {
                $.ajax({
                    url: '{{ route("admin.walkin.doctors") }}',
                    type: 'GET',
                    data: {department_id: departmentId},
                    beforeSend: function() {
                        $('#doctor_id').html('<option>Loading doctors...</option>');
                    },
                    success: function(data) {
                        $('#doctor_id').empty();
                        $('#doctor_id').append('<option value="">Select Doctor</option>');
                        
                        if(data.length === 0) {
                            $('#doctor_id').append('<option value="" disabled>No doctors available</option>');
                        } else {
                            $.each(data, function(key, value) {
                                $('#doctor_id').append('<option value="' + value.id + '">' + value.name + ' (' + value.specialization + ')</option>');
                            });
                        }
                    },
                    error: function() {
                        $('#doctor_id').html('<option value="">Error loading doctors</option>');
                    }
                });
            } else {
                $('#doctor_id').empty();
                $('#doctor_id').append('<option value="">Select Department First</option>');
            }
        });
        
        // Set minimum date for appointment to today
        var today = new Date().toISOString().split('T')[0];
        document.getElementById('appointment_date').setAttribute('min', today);
        
        // Initialize any date pickers
        if($.fn.datepicker) {
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });
        }
    });
</script>
@endsection