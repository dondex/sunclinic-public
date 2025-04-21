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
                <h5 class="text-white">Patient Appointment</h5>
            </div>
            
        </div>
    </div>

    @foreach($appointments as $appointment)
    <div class="row m-3 bg-white px-3 py-4 rounded">
        
            <!-- <div class="col-md-2 col-sm-1 col-1">
                
                @if($appointment->department && $appointment->department->image)
                    <img src="{{ asset('uploads/department/' . $appointment->department->image) }}" alt="Department Image" class="img-fluid rounded-circle" >
                @else
                    <p>No department image available.</p>
                @endif
                
            </div> -->
            <div class="col-md-8 col-8">
                <h4 class="mb-0">{{ $appointment->doctor->name }}</h4>
                <span>{{ $appointment->department->name }}</span>
                <div class="d-flex flex-column py-1">
                    <span>
                        <i class="fas fa-calendar text-primary mr-2"></i>{{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('l') }} | {{ \Carbon\Carbon::parse($appointment->appointment_date_time)->format('Y-m-d') }}
                    </span>
                    <span>
                        <i class="fas fa-clock text-primary mr-2"></i>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('g:i A') }}
                    </span>
                </div>
            </div>
            <div class="col-md-2 col-sm-2 col-2">
                @if($appointment->status == 'Pending')
                    <span class="badge bg-success">{{ $appointment->status }}</span>
                @elseif($appointment->status == 'Accepted')
                    <span class="badge bg-primary">{{ $appointment->status }}</span>
                @elseif($appointment->status == 'Declined')
                    <span class="badge bg-danger">{{ $appointment->status }}</span>
                @endif
            </div>
       
    </div>
     @endforeach

        
</div>


@endsection