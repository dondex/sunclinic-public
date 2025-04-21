@extends('layouts.master')

@section('title', 'Patient Records')

@section('content')


<div class="container-fluid">

        
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            
            <div class="card shadow-sm border-0 rounded-0">
                <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
                    <h4 class="mb-0">View Record</h4>
                    <a href="{{ url('admin/add-record') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-plus-circle text-primary"></i>Add Record</a>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                        <table id="myDataTable" class="table  table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Patient Name</th>
                                    <th>Resident Number</th>
                                    <th>Birthday</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($record as $rec)
                                    <tr>
                                        <td class="td-text">{{ $rec->id }}</td>
                                        <td class="td-text">{{ $rec->user->name }}</td>
                                        <td class="td-text">{{ $rec->resident_number }}</td>
                                        <td class="td-text">{{ \Carbon\Carbon::parse($rec->birthday)->format('F j, Y') }}</td>
                                        <td class="td-text">
                                            <a href="{{ url('admin/view-record/'.$rec->id ) }}" class="btn btn-info btn-sm" title="View">
                                                <i class="fas fa-eye"></i> <!-- Eye icon for view -->
                                            </a>
                                            <a href="{{ url('admin/records/' . $rec->id . '/edit') }}" class="btn btn-success btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i> <!-- Edit icon -->
                                            </a>

                                            <a href="#" class="btn btn-danger btn-sm" title="Delete" onclick="event.preventDefault(); confirmDelete('{{ url('admin/delete-record/'.$rec->id) }}');">
                                                <i class="fas fa-trash"></i> <!-- Trash icon for delete -->
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