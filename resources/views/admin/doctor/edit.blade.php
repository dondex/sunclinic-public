@extends('layouts.master')

@section('title', 'Edit Doctor')

@section('content')


<div class="container-fluid">

        
      

        <div class="card shadow-sm border-0 rounded-0">

        @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        </div>
        @endif


                <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
                    <h4 class="mb-0">Edit Doctor</h4>
                    <a href="{{ url('admin/doctor') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ url('admin/update-doctor/'.$doctor->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="">Department</label>
                            <select name="department_id" required class="form-control" >
                                <option value=""> -- Select Department -- </option>
                                @foreach ( $department as $depitem)
                                    <option value="{{ $depitem->id }}" {{ $doctor->department_id == $depitem->id ? 'selected': '' }}>{{ $depitem->name }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="">Doctor Name</label>
                            <input type="text" name="name" value="{{ $doctor->name }}" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary ">Update</button>
                    </form>
                </div>
        </div>

@endsection