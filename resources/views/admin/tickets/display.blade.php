@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h4 class="m-0">Live Queue Display</h4>
        </div>
        <div class="card-body">
            @include('frontend.tickets.queue-display')
        </div>
    </div>
</div>
@endsection