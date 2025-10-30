@extends('layouts.adminapp')

@section('content')

<div class="content" id="mainContent">
    <div class="container-fluid py-4">

        <!-- Header -->
        <h4 class="fw-semibold text-dark mb-4">
            <i class="fa-solid fa-user-edit me-2 text-primary"></i>Edit Profile
            <a href="{{ route('admin.profile') }}" class="btn btn-secondary btn-sm float-end">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </h4>

        <form action="{{ route('admin.update.profile') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row g-4">
                <!-- Profile Image Column -->
                <div class="col-12 col-md-4 text-center">
                    @if($admin->profile_image)
                        <img src="{{ asset('profile_images/' . $admin->profile_image) }}" 
                             class="rounded-circle border shadow-sm mb-3" 
                             width="120" height="120" style="object-fit: cover;">
                    @else
                        <img src="{{ asset('default-avatar.png') }}" 
                             class="rounded-circle border shadow-sm mb-3" 
                             width="120" height="120">
                    @endif

                    <input type="file" name="profile_image" class="form-control form-control-sm">
                
                </div>

                <!-- Editable Fields Column -->
                <div class="col-12 col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $admin->name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" value="{{ old('email', $admin->email) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-save me-1"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </form>
 

    </div>
</div>

{{-- @if($admin->profile_image)
        <form action="{{ route('admin.remove.image') }}" method="POST" class="mt-2">
              @csrf
              @method('POST')
              <button type="submit" class=" btn btn-sm btn-outline-danger  mt-3 shadow-sm"      style="margin-left: 30%; width: 110px; margin-top: -500%;">
                    <i class="fa-solid fa-trash me-1"></i> Remove
              </button>
          </form>
@endif --}}

@endsection
