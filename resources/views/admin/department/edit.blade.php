@extends('layouts.master')

@section('title', 'Sun Clinic Hospital Department')

@section('content')

<div class="container-fluid">



    @if(session('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <div class="card shadow-sm border-0 rounded-0">
        <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
            <h4 class="mb-0">Edit Department</h4>
            <a href="{{ url('admin/department') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-arrow-alt-circle-left text-primary mx-2"></i>Back</a>
        </div>
        <div class="card-body">
            <form action="{{ url('admin/update-department/'.$department->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="form-label">Department Name</label>
                    <input type="text" name="name" value="{{ $department->name }}" class="form-control" placeholder="Enter department name" required>
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label">Department Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <div class="mb-4">
                    <label for="icon" class="form-label">Department Icon</label>
                    <input type="text" name="icon" value="{{ $department->icon }}" class="form-control" placeholder="Enter Font Awesome icon class" required>
                    <small class="form-text text-muted">You can use an icon class (e.g., <code>fas fa-hospital</code>).</small>
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label">Department Description</label>
                    <textarea name="description" class="form-control" rows="4" placeholder="Enter department description" required>{{ $department->description }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary ">Update</button>
            </form>
        </div>
    </div>

</div>

@endsection