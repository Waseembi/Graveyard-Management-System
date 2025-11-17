@extends('layouts.adminapp')

@section('content')

<div class="content" id="mainContent" style="margin-top: 3%;">
    <div class="container-fluid py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-user-edit me-2"></i>Edit Profile
            </h4>
            <a href="{{ route('admin.profile') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <div class="card shadow-sm border-0 rounded-4 p-4">
            <form action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Profile Image Column -->
                    <div class="col-12 col-md-4 text-center">
                        @if($admin->profile_image)
                            <img src="{{ asset('profile_images/admin/' . $admin->profile_image) }}" 
                                 class="rounded-circle border shadow-sm mb-3" 
                                 width="130" height="130" style="object-fit: cover;">
                        @else
                            <img src="{{ asset('default-avatar.png') }}" 
                                 class="rounded-circle border shadow-sm mb-3" 
                                 width="130" height="130">
                        @endif

                        <input type="file" name="profile_image" class="form-control form-control-sm mt-2 rounded-pill">
                        <small class="text-muted d-block mt-1">Max size 2MB</small>
                    </div>

                    <!-- Editable Fields Column -->
                    <div class="col-12 col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control rounded-pill" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control rounded-pill" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control rounded-pill" placeholder="Leave blank to keep current">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-pill">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-save me-1"></i>Save Changes
                            </button>
                        </div>
                    </div>
                </div>

            </form>
        </div>

    </div>
</div>

<style>
    body {
        background-color: #e5f8ef;
    }

    .card {
        transition: 0.3s;
    }
    .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    }

    .form-control {
        border-radius: 50px;
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

    .btn-outline-secondary {
        transition: 0.3s;
    }
    .btn-outline-secondary:hover {
        background-color: #e6e6e6;
    }

    .form-label {
        font-size: 0.95rem;
    }
</style>

@endsection
