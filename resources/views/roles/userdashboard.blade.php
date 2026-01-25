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
        <!-- Unified Green Stat Overview -->
   <div class="card shadow-sm border-0 text-white mb-4" style="background: linear-gradient(180deg,#1d9e7e, rgb(26, 158, 136));  border-radius: 10px; padding:1%;" >
     <div class="card-body" >
        <div class="row" >
            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="bi bi-person-fill fs-3 me-2 ms-4 mt-1"  style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Total Registration</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $totalRegistration  }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="bi bi-people-fill  fs-3 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Family Members</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $familyCount }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="bi bi-tools fs-3 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Services Booked</h6>
                    <h3 class="fw-bold mb-0 text-center">0</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 d-flex align-items-center">
                <i class="bi bi-cash-coin fs-3 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1 ">Payments</h6>
                    <h3 class="fw-bold mb-0 text-center">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>


        <!-- ================= RECENT REGISTRATIONS ================= -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
        <span>Recent Registrations</span>
        
        <a href="{{ route('user.records') }}" class="btn btn-sm btn-outline-primary">
            View All
        </a>
    </div>

    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Status</th>
                    <th>Burial Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentRegistrations as $reg)
                <tr>
                    <td>{{ $reg->name }}</td>
                    <td>{{ $reg->father_name }}</td>
                    <td>
                        <span class="badge bg-{{ $reg->status == 'approved' ? 'success' : 'warning' }}">
                            {{ ucfirst($reg->status) }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-{{ $reg->burial_status == 'completed' ? 'success' : 'secondary' }}">
                            {{ ucfirst($reg->burial_status ?? 'Pending') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No registrations found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>



    </div>
</div>
@endsection
