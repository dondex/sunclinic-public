@extends('layouts.master')

@section('title', 'Sun Clinic Patients')

@section('content')


<div class="container-fluid">

        
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            
            <div class="card shadow-sm border-0 rounded-0">
                <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
                    <h4 class="mb-0">View Patients</h4>
                    <a href="{{ url('admin/add-doctor') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-plus-circle text-primary"></i>Add Patient</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myDataTable" class="table  table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Email</th>
                                    <th>Resident Number</th>
                                    <th>Phone Number</th>
                                    <th>Date of Birth</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td class="td-text">{{ $item->id }}</td>
                                        <td class="td-text">{{ $item->name }}</td>
                                        <td class="td-text">{{ $item->email }}</td>
                                        <td class="td-text">{{ $item->resident_number }}</td>
                                        <td class="td-text">{{ $item->phone_number }}</td>
                                        <td class="td-text">{{ \Carbon\Carbon::parse($item->birthday)->format('F j, Y') }}</td>
                                        <td class="td-text">
                                            <a href="{{ url('admin/edit-patient/'.$item->id ) }}" class="btn btn-success btn-sm">Edit</a>
                                           
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            
            

</div>

@endsection