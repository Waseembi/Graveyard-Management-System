@extends('layouts.adminapp')

@section('content')

{{-- Success message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        line-height: 1.3;
        backdrop-filter: blur(6px);
    ">
        {{ session('success') }}
    </div>
@endif

<div class="content" id="mainContent">
    <div class="container-fluid mt-4">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark">
                    <i class="fa-solid fa-user-gear me-2 text-primary"></i>Admin Profile
                </h4>
                <p class="text-muted mb-0">View and manage your account details.</p>
            </div>
        </div>


        <!-- Profile Image Section -->
<div class="text-center mb-4">
    @if($admin->profile_image)
    <img src="{{ asset('profile_images/' . $admin->profile_image) }}" class="rounded-circle shadow" width="120" height="120" style="object-fit: cover;">
@else
    <img src="{{ asset('default-avatar.png') }}" class="rounded-circle shadow" width="120" height="120">
@endif

    <form action="{{ route('admin.update.image') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        <div class="d-flex justify-content-center align-items-center gap-2">
            <input type="file" name="profile_image" class="form-control form-control-sm" style="max-width: 250px;">
            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
        </div>
    </form>
    @if($admin->profile_image)
        <form action="{{ route('admin.remove.image') }}" method="POST" class="mt-2">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger">Remove Image</button>
        </form>
    @endif
</div>


        <!-- Admin Info Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold text-dark">Profile Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Name:</strong> {{ $admin->name }}</div>
                    <div class="col-md-6"><strong>Email:</strong> {{ $admin->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Password:</strong> ********</div>
                    <div class="col-md-6"><strong>Joined On:</strong> {{ $admin->created_at->format('d M Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <strong>Role:</strong>
                        <span class="badge bg-{{ $admin->role_id == 1 ? 'primary' : 'secondary' }}">
                            {{ $admin->role_id == 1 ? 'Administrator' : 'User' }}
                        </span>
                    </div>
                </div>
                <div class="card-body d-flex justify-content-end gap-2">
                <a href="" class="btn btn-outline-success">
                    <i class="fa-solid fa-pen me-1"></i>Edit Profile
                </a>
                <a href="" class="btn btn-outline-warning">
                    <i class="fa-solid fa-key me-1"></i>Change Password
                </a>
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

    // Sidebar toggle fix
    document.getElementById("toggleSidebarBtn")?.addEventListener("click", function () {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("d-none");
    });
</script>

@endsection
