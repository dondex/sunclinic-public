@extends('layouts.app')

@section('title', 'Sun Clinic Hospital')

@section('content')

<div class="container-fluid bg-green p-1">
    <div class="row mx-2">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <a href="{{ url('/') }}" class="btn btn-success btn-sm shadow-sm my-3">
                    <i class="fas fa-chevron-left text-white p-2"></i>
                </a>
            </div>
            <div class="text-center">
                <h5 class="text-white">All Departments</h5>
            </div>
            
        </div>
    </div>

    <div class="row m-3 bg-white px-1 py-4 rounded">
        @foreach($departments as $dept)
            <div class="col-6 mb-4">
                <div class="card h-100"> <!-- Use h-100 to make all cards the same height -->
                    <img src="{{ asset('uploads/department/' . $dept->image) }}" class="card-img-top" alt="{{ $dept->name }}">
                    <div class="card-body">
                        <div style="font-size: 12px;" class="card-title">{{ $dept->name }}</div>
                        <p style="font-size: 10px;" class="card-text">{{ $dept->description }}</p>
                        <a href="{{ url('department/' . $dept->id) }}" class="btn btn-success btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection