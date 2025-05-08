@extends('layouts.app-nonav')

@section('title', 'Obeid Hospital')

@section('content')

<div class="container-fluid bg-blue p-1">
    <div class="row mx-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ url('/') }}" class="btn btn-primary btn-sm shadow-sm my-3">
                    <i class="fas fa-chevron-left text-white p-2"></i>
                </a>
            </div>
            <div class="text-center">
                <h5 class="text-white">Book Appointment</h5>
            </div>
            
        </div>
    </div>

    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
           
    <div class="row m-3 bg-white px-1 py-4 rounded">
        <div class="">
            <form action="{{ url('/set-appointment/{user_id}') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="">Patient Name</label>
                    <select name="user_id" class="form-control">
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="department_id">Department</label>
                    <select name="department_id" id="department_id" class="form-control">
                        <option value="">Select a department</option>
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="doctor_id">Doctor</label>
                    <select name="doctor_id" id="doctor_id" class="form-control">
                        <option value="">Select a doctor</option>
                        <!-- Doctors will be populated based on department selection -->
                    </select>
                </div>

                <div class="mb-3">
                    <label for="">Subject</label>
                    <input type="text" name="subject" class="form-control" />
                </div>

                <div class="mb-3">
                    <label for="">Appointment Date</label>
                    <input type="date" name="appointment_date_time" class="form-control" />
                </div>

                <div class="mb-3">
                    <label for="appointment_time">Appointment Time</label>
                    <input type="time" name="appointment_time" class="form-control" required />
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>     
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#department_id').change(function() {
            var departmentId = $(this).val();
            if (departmentId) {
                $.ajax({
                    url: '/doc-by-dept', // This is correct
                    type: 'GET',
                    data: { department_id: departmentId },
                    success: function(data) {
                        $('#doctor_id').empty();
                        $('#doctor_id').append('<option value="">Select a doctor</option>');
                        $.each(data, function(key, doctor) {
                            $('#doctor_id').append('<option value="' + doctor.id + '">' + doctor.name + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.error(xhr);
                    }
                });
            } else {
                $('#doctor_id').empty();
                $('#doctor_id').append('<option value="">Select a doctor</option>');
            }
        });
    });
</script>
@endsection