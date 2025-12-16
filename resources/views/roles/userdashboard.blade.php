{{-- @extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Welcome -->
        <div class="mb-4">
            <h4>Welcome, {{ Auth::user()->name ?? 'User' }} 👋</h4>
            <p class="text-muted">Here’s an overview of your account.</p>
        </div>

    </div>
</div>
@endsection --}}





@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- ================= WELCOME ================= -->
        <div class="mb-4">
            <h4>Welcome, {{ Auth::user()->name ?? 'User' }} 👋</h4>
            <p class="text-muted">Here’s an overview of your account.</p>
        </div>

        <!-- ================= SUMMARY CARDS ================= -->
        <div class="row mb-4">

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Total Registration</h6>
                        <h3 class="fw-bold">0</h3>
                        <i class="bi bi-geo-alt-fill fs-2 text-primary"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Family Members</h6>
                        <h3 class="fw-bold">0</h3>
                        <i class="bi bi-people-fill fs-2 text-success"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Services Booked</h6>
                        <h3 class="fw-bold">0</h3>
                        <i class="bi bi-tools fs-2 text-danger"></i>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <h6 class="text-muted">Payments</h6>
                        <h3 class="fw-bold">0</h3>
                        <i class="bi bi-cash-coin fs-2 text-warning"></i>
                    </div>
                </div>
            </div>

        </div>

        <!-- ================= QUICK ACTIONS ================= -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                Quick Actions
            </div>
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <a href="{{ route('user.register.create') }}" class="btn btn-primary w-100">
                            <i class="bi bi-plus-circle"></i> Register Grave
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('family.create') }}" class="btn btn-success w-100">
                            <i class="bi bi-person-plus"></i> Add Family Member
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="{{ route('search') }}" class="btn btn-warning w-100">
                            <i class="bi bi-search"></i> Search Burial
                        </a>
                    </div>

                    <div class="col-md-3">
                        <a href="#" class="btn btn-danger w-100">
                            <i class="bi bi-credit-card"></i> Make Payment
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= RECENT ACTIVITY ================= -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white fw-bold">
                Recent Activity
            </div>
            <div class="card-body p-0">
                <table class="table mb-0 table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>Activity</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Grave Registered</td>
                            <td>12 Sep 2025</td>
                            <td><span class="badge bg-success">Completed</span></td>
                        </tr>
                        <tr>
                            <td>Payment Submitted</td>
                            <td>10 Sep 2025</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>Marble Service Booked</td>
                            <td>08 Sep 2025</td>
                            <td><span class="badge bg-info">Processing</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ================= NOTIFICATIONS ================= -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-bold">
                Notifications
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        💡 Your payment is pending approval.
                    </li>
                    <li class="list-group-item">
                        📢 Marble service booking confirmed.
                    </li>
                </ul>
            </div>
        </div>

    </div>
</div>
@endsection
