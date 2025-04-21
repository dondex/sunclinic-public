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
                <h5 class="text-white">Patients Profile</h5>
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

        <div>    
            @if($records->isNotEmpty() && $records->first()->profile_image) <!-- Check if records exist and profile_image exists -->
                <img src="{{ asset($records->first()->profile_image) }}" alt="Profile Picture" class="img-fluid rounded-circle my-2" style="width: 75px; height: 75px;">
            @else
                    <p>No profile picture available.</p>
            @endif
            <h3 class="text-2xl font-bold text-capitalize pb-2">{{ $user->name }}'s Profile</h3>
            <p><strong>Resident Number:</strong> {{ $user->resident_number }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
           

            @if($records->isNotEmpty())

                <p><strong>Phone Number:</strong> {{ $records->first()->phone_number }}</p>
                <p><strong>Birthday:</strong> {{ \Carbon\Carbon::parse($records->first()->birthday)->format('M j, Y') }}</p>
                <p class="text-capitalize"><strong>Address:</strong> {{ $records->first()->address }}</p>
                <p class="text-capitalize"><strong>Gender:</strong> {{ $records->first()->gender }}</p>

                <a href="{{ url('profile/edit/' . $user->id) }}" class="btn btn-primary btn-sm mt-3 p-2">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
                
            @else
                <p><strong>Phone Number:</strong>Not available</p>
                <p><strong>Birthday:</strong>Not available</p>
                <p><strong>Address:</strong> Not available</p>
                <p><strong>Gender:</strong> Not available</p>

                <a href="{{ url('profile/create/' . $user->id) }}" class="btn btn-success btn-sm mt-3 p-2">
                    <i class="fas fa-plus"></i> Create Profile
                </a>
            @endif

          

        </div>
    </div>

</div>

@endsection 