@extends('layouts.adminapp')

@section('content')

{{-- Success Alert --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-3 shadow-lg rounded-pill px-4 py-2" style="
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        backdrop-filter: blur(6px);
    ">
        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
    </div>
@endif

<div class="content" id="mainContent">
    <div class="container-fluid py-4" >

        <!-- Header -->
        <div class="mb-4">
            <h4 class="fw-bold text-success mb-1">
                <i class="fa-solid fa-user-circle me-2"></i> Admin Profile
            </h4>
            <p class="text-muted mb-0">Manage your account and profile settings.</p>
        </div>

        <div class="row justify-content-center g-4" style="margin-left: -15%;">
            <!-- Left Profile Card -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card shadow-sm text-center h-100 border-0 rounded-4">
                    <div class="card-body p-4">
                        @if($admin->profile_image)
                            <img src="{{ asset('profile_images/admin/' . $admin->profile_image) }}" 
                                 class="rounded-circle border border-3 border-success shadow-sm" width="120" height="120" 
                                 style="object-fit: cover;">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" 
                                 class="rounded-circle border border-3 border-success shadow-sm" width="120" height="120">
                        @endif

                        <h5 class="fw-bold text-dark mt-3">{{ $admin->name }}</h5>
                        <small class="text-muted">{{ $admin->email }}</small>
                        <span class="badge bg-success mt-2 px-3 py-1 rounded-pill">
                            {{ $admin->role_id == 1 ? 'Administrator' : 'User' }}
                        </span>

                        <hr class="my-3">
                        <a href="{{ route('admin.edit.profile') }}" class="btn btn-outline-success btn-sm w-100 rounded-pill">
                            <i class="fa-solid fa-pen me-1"></i> Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Info Card -->
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm h-100 border-0 rounded-4">
                    <div class="card-header bg-success text-white fw-semibold rounded-top">
                        <i class="fa-solid fa-circle-info me-2"></i> Profile Details
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Full Name</div>
                            <div class="col-7 fw-semibold">{{ $admin->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Email</div>
                            <div class="col-7 fw-semibold">{{ $admin->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Password</div>
                            <div class="col-7 fw-semibold">********</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Joined On</div>
                            <div class="col-7 fw-semibold">{{ $admin->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
setTimeout(() => {
    const alert = document.getElementById("success-alert");
    if (alert) {
        alert.classList.add("fade");
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);
</script>

{{-- Styling --}}
<style>
    .card {
        border-radius: 15px !important;
    }
    .btn-success {
        background: linear-gradient(135deg, #34c759, #1e8e3e);
        border: none;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #2e7d32, #145a32);
    }
    .btn-outline-success {
        border-color: #2e7d32;
        color: #2e7d32;
    }
    .btn-outline-success:hover {
        background-color: #2e7d32;
        color: #fff;
    }
    .badge {
        font-size: 0.85rem;
    }
</style>
@endsection
