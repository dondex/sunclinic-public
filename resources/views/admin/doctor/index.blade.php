@extends('layouts.master')

@section('title', 'Sun Clinic Hospital')

@section('content')


<div class="container-fluid">

        
            @if(session('message'))
                <div class="alert alert-success">{{ session('message') }}</div>
            @endif
            
            <div class="card shadow-sm border-0 rounded-0">
                <div class="card-header d-sm-flex align-items-center justify-content-between bg-primary text-white">
                    <h4 class="mb-0">View Doctor</h4>
                    <a href="{{ url('admin/add-doctor') }}" class="btn btn-light btn-sm shadow-sm"><i class="fas fa-plus-circle text-primary"></i> Add Doctor</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="myDataTable" class="table  table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Doctor Name</th>
                                    <th>Department</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctors as $item)
                                    <tr>
                                        <td class="td-text">{{ $item->id }}</td>
                                        <td class="td-text">{{ $item->name }}</td>
                                        <td class="td-text">{{ $item->department ? $item->department->name : 'No Department' }}</td>
                                        

                                        <td class="td-text">    
                                            <a href="{{ url('admin/edit-doctor/'.$item->id ) }}" class="btn btn-success btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i> <!-- Edit icon -->
                                            </a>
                                            <a href="#" class="btn btn-danger btn-sm" title="Delete" onclick="event.preventDefault(); confirmDelete('{{ url('admin/delete-doctor/'.$item->id) }}');">
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