@extends('layouts.app')

@section('title', 'Obeid Hospital')

@section('content')

<div class="container">
    <div class="row" >
        <div class="col-12 ">
        <h3 class="blue">
                @auth
                    Welcome, {{ Auth::user()->name }}!
                @else
                    Welcome, Guest!
                @endauth
            </h3>
        </div>
    </div>
</div>

<div class="container  bg-white">
    <div class="row mt-2 ">

        <div class="col-md-6 col-sm-6 col-6 text-center rounded">
                @if(Auth::check())
                    <a style="text-decoration: none;" class="text-white" href="{{ url('medical/' . Auth::id()) }}">
                        <div class="px-1 py-4 bg-blue rounded-lg">
                            <i class="fas fa-file-medical text-white icon-size pb-2"></i>
                            <h6 class="h6-txt">Medical Files</h6>
                        </div>
                    </a>
                @else
                    <a style="text-decoration: none;" class="text-white" href="{{ route('login') }}"> <!-- Assuming you have the login route named 'login' -->
                        <div class="px-3 py-4 bg-blue rounded-lg">
                            <i class="fas fa-file-medical text-white icon-size pb-2"></i>
                            <h6 class="h6-txt">Medical Files</h6>
                        </div>
                    </a>
                @endif
            </div>

            <div class="col-md-6 col-sm-6 col-6 text-center  rounded  ">
                @if(Auth::check())
                    <a style="text-decoration: none;" class="text-white" href="{{ url('lab-result/' . Auth::id()) }}">
                        <div class="px-3 py-4 bg-blue rounded-lg">
                            <i class="fas fa-flask text-white icon-size pb-2"></i>
                            <h6 class="h6-txt">Lab & Radiology Result</h6>
                        </div>
                    </a>
                @else
                    <a style="text-decoration: none;" class="text-white" href="{{ route('login') }}"> <!-- Assuming you have the login route named 'login' -->
                        <div class="px-3 py-4 bg-blue rounded-lg">
                            <i class="fas fa-flask text-white icon-size pb-2"></i>
                            <h6 class="h6-txt">Lab & Radiology Result</h6>
                        </div>
                    </a>
                @endif
                
            </div>

            
        </div>

        <div class="row py-3">  
            <div class="col-md-12 col-sm-12 col-12 text-center rounded">
                    @if(Auth::check())
                        <a style="text-decoration: none;" class="text-white" href="{{ url('set-appointment/' . Auth::id()) }}">
                            <div class="px-1 py-4 bg-blue rounded-lg">
                                <i class="fas fa-calendar text-white icon-size pb-2"></i>
                                <h6 class="h6-txt">Book Appointment</h6>
                            </div>
                        </a>
                    @else
                        <a style="text-decoration: none;" class="text-white" href="{{ route('login') }}"> <!-- Assuming you have the login route named 'login' -->
                            <div class="px-3 py-4 bg-blue rounded-lg">
                                <i class="fas fa-calendar text-white icon-size pb-2"></i>
                                <h6 class="h6-txt">Book Appointment</h6>
                            </div>
                        </a>
                    @endif
                </div>
        </div>
</div>



<!-- <div class="container">
    <div class="row">
        <div class="col-12 p-0 m-0">
            <img class="banner-style rounded-lg" src="{{asset('uploads/obeid-banner.jpeg') }}" alt="">
        </div>
    </div>
</div> -->



<div class="container">
    <div class="row">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="d-block w-100 rounded-lg shadow-sm" src="{{ asset('uploads/obeid-banner.jpeg') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 rounded-lg shadow-sm" src="{{ asset('uploads/banner4.jpeg') }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="d-block w-100 rounded-lg shadow-sm" src="{{ asset('uploads/banner3.jpeg') }}" alt="Third slide">
                </div>
            </div>
           
        </div>
    </div>
</div>

<div class="container py-2" id="dept-section">
    <div class="row">
        <div class="py-3">
            <h3 class="blue">Departments</h3>
        </div>

        @foreach($department as $dept)
            <div class="col-md-4 col-sm-4 col-4">
                <div class="p-3 my-2 bg-blue text-center rounded shadow-sm">
                    <a style="text-decoration: none;" class="text-white" href="{{ url('department/' . $dept->id) }}">
                        <i class="{{ $dept->icon }} text-white icon-size-dept pb-2"></i>
                        <h6 class="h6-txt text-white">{{ $dept->name }}</h6>
                    </a>
                    
                    <!-- <h6 class="h6-txt">
                        <a style="text-decoration: none;" class="text-white" href="{{ url('department/' . $dept->id) }}">{{ $dept->name }}</a> 
                    </h6>  -->
                </div>
            </div>
        @endforeach

    </div>
</div>




@endsection