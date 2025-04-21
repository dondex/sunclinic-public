@extends('layouts.master')

@section('title', 'Sun Clinic Patients')

@section('content')


<div class="container-fluid">

        
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            
            <div class="card shadow-sm border-0 rounded-0">
                <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
                    <h4 class="mb-0">Edit Patients</h4>
                    <a href="{{ url('admin/patients') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/update-patient/'.$user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                        <div class="mb-3">
                            <label>Patient Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-control" />
                            
                            <label>Email</label>
                            <input type="text" name="email" value="{{ $user->email }}" class="form-control" />

                            <label>Resident Number</label>
                            <input type="text" name="resident_number" value="{{ $user->resident_number }}" class="form-control" />

                            <label>Phone Number</label>
                            <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="form-control" />

                            <label>Birthday</label>
                            <input type="date" name="birthday" value="{{ $user->birthday }}" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary ">Update</button>
                    </form>
                </div>
            </div>
</div>

@endsection