@extends('layouts.app')

@section('title', 'Obeid Hospital')

@section('content')

<div class="section-bg pb-5">
    <section>
        <div class="container">
            <div class="row bg-img-profile row-space row-radius1 ">
                <div class="col-6 ">
                    <!-- <i class="fas fa-book icon-header"></i> -->
                </div>
                <!-- <div class="col-6 ">
                    <h3 class="text-center">Book Appointment</h3>
                </div> -->
            </div>
        </div>
    </section>

    
    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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

                <a href="{{ url('profile/edit/' . $user->id) }}" class="btn btn-success btn-sm mt-3 p-2">
                    <i class="fas fa-edit"></i> Edit Profile
                </a>
                
                @else
                    <p><strong>Phone Number:</strong> Not available</p>
                    <p><strong>Birthday:</strong> Not available</p>
                    <p><strong>Address:</strong> Not available</p>
                    <p><strong>Gender:</strong> Not available</p>

                    <hr>

                    <h4 class="mt-4">Create Profile</h4>
                    <form action="{{ url('profile/add/' . $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="profile_image">Profile Image</label>
                            <input type="file" name="profile_image" id="profile_image" class="form-control" accept="image/*">
                        </div>

                        <div class="form-group">
                            <label for="phone_number">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" name="birthday" id="birthday" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-success btn-sm mt-3 p-2">
                            <i class="fas fa-plus"></i> Create Profile
                        </button>
                    </form>
                @endif

          

        </div>
    </div>

</div>

@endsection 