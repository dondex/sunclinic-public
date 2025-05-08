@extends('layouts.app-nonav')

@section('title', 'Sun Clinic Hospital')

@section('content')

<div class="container-fluid bg-green p-1">
    <div class="row mx-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ url('all-department') }}" class="btn btn-success btn-sm shadow-sm my-3">
                    <i class="fas fa-chevron-left text-white p-2"></i>
                </a>
            </div>
            <div class="text-center">
                <h5 class="text-white">Departments</h5>
            </div>
            
        </div>
    </div>

    <div class="row m-3 bg-white px-1 py-4 rounded">
        <div>
         

            <h3>{{ $department->name }}</h3> <!-- Display the department name -->
            <p>{{ $department->description }}</p> <!-- Display the department description -->

            <!-- Display the department image -->
            @if($department->image)
                <div>
                    <img src="{{ asset('uploads/department/' . $department->image) }}" alt="{{ $department->name }}" class="img-fluid rounded" />
                </div>
            @endif

           
             <div class="py-3">
                @if($department->doctors->isNotEmpty())
                    <h3>Doctors in this Department:</h3>
                    <ul>
                        @foreach($department->doctors as $doctor)
                            <li>{{ $doctor->name }}</li> 
                        @endforeach
                    </ul>
                @else
                    <p>No doctors available in this department.</p>
                @endif
             </div>
           

            <div>
                <button class="btn btn-success text-white">
                    <a style="text-decoration: none;" class="text-white" href="{{ url('set-appointment/' . Auth::id()) }}">Book Appointment Now!</a>
                </button>
            </div>
           
        </div>
    </div>
</div>





@endsection