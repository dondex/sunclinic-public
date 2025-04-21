@extends('layouts.master')

@section('title', 'Sun Clinic Hospital')

@section('content')


<div class="container-fluid">

        
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            
            <div class="card shadow-sm border-0 rounded-0">
                <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
                    <h4 class="mb-0">View Appointments</h4>
                    <a href="{{ url('admin/add-appointment') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-plus-circle text-primary"></i>Add Appointment</a>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                        <table id="myDataTable" class="table  table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Department</th>
                                    <th>Doctor</th>
                                    <th>Subject</th>
                                    <th>Appointment Time</th>
                                    <th>Appointment Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $item)
                                    <tr>
                                        <td class="td-text">{{ $item->id }}</td>
                                        <td class="td-text">{{ $item->user->name }}</td>
                                        <td class="td-text">{{ $item->department->name }}</td>
                                        <td class="td-text">{{ $item->doctor->name }}</td>
                                        <td class="td-text">{{ $item->subject }}</td>
                                        <td class="td-text">{{ \Carbon\Carbon::parse($item->appointment_time)->format('g:i A') }}</td>
                                        <td class="td-text">{{ \Carbon\Carbon::parse($item->appointment_date_time)->format('F j, Y') }}</td>
                                        <td class="td-text">
                                            @if($item->status == 'Pending')
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @elseif($item->status == 'Accepted')
                                                <span class="badge bg-primary">{{ $item->status }}</span>
                                            @elseif($item->status == 'Declined')
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                       

                                        <td class="td-text">    
                                            <a href="{{ url('admin/appointment/'.$item->id ) }}" class="btn btn-success btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i> <!-- Edit icon -->
                                            </a>
                                           
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