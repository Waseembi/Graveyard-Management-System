@extends('layouts.userapp')

@section('content')

@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.75rem 1.25rem;
    line-height: 1.4;
    backdrop-filter: blur(6px);
    ">
    {{ session('success') }}
    </div>
@endif

<div class="content" id="mainContent">
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="mb-4">
            <h4 class="fw-semibold text-dark mb-1">
                <i class="fa-solid fa-user-circle me-2 text-secondary"></i>User Profile
            </h4>
            <p class="text-muted mb-0">Manage your account and profile settings.</p>
        </div>

        <div class="row justify-content-center g-4">
            <!-- Left Profile Card -->
            <div class="col-12 col-md-4 col-lg-3" style="margin-left: -25%">
                <div class="card shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        @if($user->profile_image)
                            <img src="{{ asset('profile_images/user/' . $user->profile_image) }}" 
                                 class="rounded-circle border shadow-sm" width="110" height="110" 
                                 style="object-fit: cover;">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" 
                                 class="rounded-circle border shadow-sm" width="110" height="110">
                        @endif

                        <h6 class="fw-semibold text-dark mt-3">{{ $user->name }}</h6>
                        <small class="text-muted">{{ $user->email }}</small>
                        <span class="badge bg-secondary mt-2">
                            {{ $user->role_id == 1 ? 'administrator' : 'User' }}
                        </span>

                        <hr>
                        <a href="{{ route('user.edit.profile') }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                            <i class="fa-solid fa-pen me-1"></i>Edit Profile
                        </a>
                    </div>
                </div>
            </div>

            <!-- Right Info Card -->
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0 fw-semibold text-dark">
                            <i class="fa-solid fa-circle-info me-2 text-secondary"></i>Profile Details
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Full Name</div>
                            <div class="col-7 text-dark">{{ $user->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Email</div>
                            <div class="col-7 text-dark">{{ $user->email }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Password</div>
                            <div class="col-7 text-dark">********</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-5 text-muted">Joined On</div>
                            <div class="col-7 text-dark">{{ $user->created_at->format('d M Y') }}</div>
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

@endsection
