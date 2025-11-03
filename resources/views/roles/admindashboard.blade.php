@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Welcome -->
        <div class="mb-4">
            <h4>Welcome, {{ Auth::user()->name ?? 'User' }} 👋</h4>
        </div>

        <!-- Stats Cards -->
        {{-- <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalUsers }}</h5>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalRegistrations }}</h5>
                        <p class="text-muted mb-0">Total Registration</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">0</h5>
                        <p class="text-muted mb-0">Total Buried</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">0</h5>
                        <p class="text-muted mb-0">Payments</p>
                    </div>
                </div>
            </div>
        </div> --}}
        <!-- Quick Actions -->
<div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow border-0" style="background: linear-gradient(135deg, #4CAF50, #81C784); color: white;">
                    <div class="card-body">
                        <i class="bi bi-people-fill fs-2 mb-2"></i>
                        <h5 class="card-title">{{ $totalUsers }}</h5>
                        <p class="mb-0">Total Users</p>
                    </div>
                </div>
            </div>

    <div class="col-md-3">
        <div class="card text-center shadow border-0" style="background: linear-gradient(135deg, #2196F3, #64B5F6); color: white;">
            <div class="card-body">
                <i class="bi bi-file-earmark-text-fill fs-2 mb-2"></i>
                <h5 class="card-title">{{ $totalRegistrations }}</h5>
                <p class="mb-0">Total Registrations</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center shadow border-0" style="background: linear-gradient(135deg, #9C27B0, #BA68C8); color: white;">
            <div class="card-body">
                <i class="bi bi-tree-fill fs-2 mb-2"></i>
                <h5 class="card-title">{{ $totalBurials }}</h5>
                <p class="mb-0">Total Buried</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card text-center shadow border-0" style="background: linear-gradient(135deg, #FF9800, #FFB74D); color: white;">
            <div class="card-body">
                <i class="bi bi-wallet2 fs-2 mb-2"></i>
                <h5 class="card-title">0</h5>
                <p class="mb-0">Total Payments</p>
            </div>
        </div>
    </div>
</div>


        <!-- Recent Activity -->
        {{-- <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0">Recent Activity</h6>
            </div>
            <div class="card-body">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-10-22</td>
                            <td>Grave Request #124</td>
                            <td><span class="badge bg-success">Approved</span></td>
                        </tr>
                        <tr>
                            <td>2025-10-20</td>
                            <td>Payment Submitted</td>
                            <td><span class="badge bg-info text-dark">Verified</span></td>
                        </tr>
                        <tr>
                            <td>2025-10-18</td>
                            <td>Grave Request #125</td>
                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div> --}}
        <!-- Recent Registrations -->
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white">
        <h6 class="mb-0">Recent Registrations</h6>
    </div>
    <div class="card-body">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>CNIC</th>
                    <th>Age</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentRegistrations as $index => $reg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reg->name }}</td>
                    <td>{{ $reg->father_name }}</td>
                    <td>{{ $reg->cnic ?? 'N/A' }}</td>
                    <td>{{ $reg->age }}</td>
                    <td>
                        <span class="badge bg-{{ $reg->status == 'approved' ? 'success' : ($reg->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                            {{ ucfirst($reg->status) }}
                        </span>
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
