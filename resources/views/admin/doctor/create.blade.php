@extends('layouts.master')

@section('title', 'Add Doctor')

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
                    <h4 class="mb-0">Add Doctor</h4>
                    <a href="{{ url('admin/doctor') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/add-doctor') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="">Department</label>
                            <select name="department_id" class="form-control" >
                                @foreach ( $department as $depitem)
                                    <option value="{{ $depitem->id }}">{{ $depitem->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Doctor Name</label>
                            <input type="text" name="name" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary ">Submit</button>
                    </form>
                </div>
        </div>

@endsection