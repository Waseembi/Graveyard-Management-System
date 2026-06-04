@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: -40px;">
            <h4 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-cross me-2"></i>Pending Burial Requests
            </h4>
            <a href="" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4 p-4">
            <h5 class="fw-bold mb-4 text-primary">Burial Registrations</h5>

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th><i class="fa-solid fa-user me-2"></i>Name</th>
                        <th><i class="fa-solid fa-user-tie me-2"></i>Father Name</th>
                        <th><i class="fa-solid fa-id-card me-2"></i>CNIC</th>
                        <th><i class="fa-solid fa-phone me-2"></i>Phone</th>
                        <th><i class="fa-solid fa-calendar-check me-2"></i>Status</th>
                        <th><i class="fa-solid fa-gear me-2"></i>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($requests as $reg)
                        <tr>
                            <td>{{ $reg->name }}</td>
                            <td>{{ $reg->father_name }}</td>
                            <td>{{ $reg->cnic ?? 'N/A' }}</td>
                            <td>{{ $reg->phone }}</td>
                            <td>
                                <span class="badge bg-success rounded-pill">{{ $reg->status }}</span>
                            </td>
                            <td><a href="{{ route('admin.burial.requests.show', $reg->id) }}">View</a></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<style>
    body {
        background-color: #f5fdf9;
    }
    .card {
        transition: 0.3s;
    }
    .form-control, .form-select {
        padding: 0.6rem 1rem;
    }
    .btn-success {
        background-color: #1d9e7e;
        border: none;
        transition: 0.3s;
    }
    .btn-success:hover {
        background-color: #157359;
    }
    .btn-outline-secondary:hover {
        background-color: #e6e6e6;
    }
</style>
@endsection






{{-- @extends('layouts.adminapp')

@section('content')
<h2>Pending Burial Requests</h2>
<table>
    <tr><th>User</th><th>Grave</th><th>Status</th><th>Action</th></tr>
    @foreach($requests as $req)
        <tr>
            <td>{{ $req->user->name }}</td>
            <td>{{ $req->grave->id ?? 'N/A' }}</td>
            <td>{{ $req->status }}</td>
            <td><a href="{{ route('admin.burial.requests.show', $req->id) }}">View</a></td>
        </tr>
    @endforeach
</table>
@endsection --}}
