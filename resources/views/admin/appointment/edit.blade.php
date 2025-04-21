@extends('layouts.master')

@section('title', 'Edit Appointment')

@section('content')

<div class="container-fluid">

    @if(session('message'))
    <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-0">

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        </div>
        @endif

        <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
            <h4 class="mb-0">Edit Appointment</h4>
            <a href="{{ url('admin/appointments') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back</a>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/update-appointment', $appointment->id) }}" method="POST">
                @csrf
                @method('PUT') 
                <div class="mb-3">
                    <label for="">Patient Name</label>
                    <select name="user_id" class="form-control">
                        @foreach ($users as $useritem)
                            <option value="{{ $useritem->id }}" {{ $useritem->id == $appointment->user_id ? 'selected' : '' }}>
                                {{ $useritem->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="">Department</label>
                    <select name="department_id" class="form-control">
                        @foreach ($departments as $dept)
                            <option value="{{ $dept->id }}" {{ $dept->id == $appointment->department_id ? 'selected' : '' }}>
                                {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="">Doctor</label>
                    <select name="doctor_id" class="form-control">
                        @foreach ($doctors as $doctoritem)
                            <option value="{{ $doctoritem->id }}" {{ $doctoritem->id == $appointment->doctor_id ? 'selected' : '' }}>
                                {{ $doctoritem->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="">Subject</label>
                    <input type="text" name="subject" class="form-control" value="{{ old('subject', $appointment->subject) }}" />
                </div>

                <div class="mb-3">
                    <label for="">Appointment Date</label>
                    <input type="date" name="appointment_date_time" class="form-control" value="{{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('Y-m-d') }}" />
                </div>

                <div class="mb-3">
                    <label for="appointment_time">Appointment Time</label>
                    <input type="time" name="appointment_time" class="form-control" value="{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}" required />
                </div>

                <div class="mb-3">
                    <label for="status">Status</label>
                    <select name="status" class="form-control">
                        <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Accepted" {{ $appointment->status == 'Accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="Declined" {{ $appointment->status == 'Declined' ? 'selected' : '' }}>Declined</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

@endsection