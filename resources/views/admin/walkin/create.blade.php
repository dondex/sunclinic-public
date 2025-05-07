@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Walk-in Patient</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Register Walk-in Patient</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.walkin.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Patient Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Phone Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                        <small class="text-muted">Optional</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birth_date">Birth Date</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                    </div>
                </div>
                

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="department_id">Department <span class="text-danger">*</span></label>
                        <select class="form-control" id="department_id" name="department_id" required>
                            <option value="">Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="doctor_id">Doctor <span class="text-danger">*</span></label>
                        <select class="form-control" id="doctor_id" name="doctor_id" required>
                            <option value="">Select Department First</option>
                        </select>
                    </div>
                </div>
                


                <div class="form-group mt-4">
                    <button type="submit" class="btn btn-primary">Register Patient & Generate Ticket</button>
                    <a href="{{ url('admin/dashboard') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Load doctors when department is selected
        $('#department_id').change(function() {
            var departmentId = $(this).val();
            if(departmentId) {
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