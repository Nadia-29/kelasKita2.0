@extends('admin.layouts.app')

@section('content')
    <h2>Dashboard</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header">Total User</div>
                <div class="card-body">
                    <h5 class="card-title">150</h5> </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Total Kelas</div>
                <div class="card-body">
                    <h5 class="card-title">12</h5> </div>
            </div>
        </div>
    </div>
@endsection