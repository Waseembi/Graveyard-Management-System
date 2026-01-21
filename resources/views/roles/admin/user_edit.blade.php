@extends('layouts.adminapp')

@section('content')

{{-- Success message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
        position: absolute;
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
    ">      
        {{ session('success') }}
    </div>
@endif
 {{-- Validation Errors --}}
    @if ($errors->any())
        <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 400px;
            z-index: 1050;
            box-shadow: 0 0.5rem 1rem rgba(128, 0, 0, 0.2);
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            line-height: 1.3;
        ">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li style="list-style-type: none">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{-- Error message --}}
@if(session('error'))
    <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(255, 0, 0, 0.2);
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        line-height: 1.3;
    ">      
        {{ session('error') }}
    </div>
@endif

<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark"><i class="fa-solid fa-user-pen me-2 text-warning"></i>Update User</h4>
                <p class="text-muted mb-0">Modify user personal information and approval status.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Update Form -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold text-dark">Edit User Details</h6>
            </div>
            <div class="card-body">
                {{-- @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif --}}

                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Father Name</label>
                            <input type="text" name="father_name" value="{{ old('father_name', $user->father_name) }}" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CNIC</label>
                            <input type="text" name="cnic" value="{{ old('cnic', $user->cnic) }}" class="form-control shadow-sm" placeholder="xxxxx-xxxxxxx-x" >
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="form-control shadow-sm" placeholder="03xx-xxxxxxx">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Age</label>
                            <input type="number" name="age" value="{{ old('age', $user->age) }}" class="form-control shadow-sm" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select shadow-sm">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $user->gender)=='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $user->gender)=='female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"> Date of Birth</label>
                            <input type="date" name="dob" max="{{ date('Y-m-d') }}" required value="{{ old('dob', $user->dob) }}" class="form-control shadow-sm">
                        </div>
                </div>

                    <div class="row mb-4">
                        {{-- // this will disable status change if burial_status is 'buried' --}}
                        {{-- @if($user->burial_status !== 'buried')
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Status</label>
                                <select name="status" class="form-select shadow-sm" required>
                                    <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        @endif --}}

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status</label>
                            <select name="status" class="form-select shadow-sm" {{ $user->burial_status === 'buried' ? 'disabled' : '' }} required>
                                <option value="approved" {{ $user->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                         </div>  


                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Burial Status</label>
                            <select name="burial_status" class="form-select shadow-sm" required>
                                {{-- Show the current value as the first option --}}
                                <option value="{{ $user->burial_status }}" selected>{{ ucfirst(str_replace('_', ' ', $user->burial_status)) }}</option>

                                 {{-- Only allow selecting "not_buried" if current value is "buried" --}}
                                 @if($user->burial_status === 'buried')
                                     <option value="not_buried">Not Buried</option>
                                 @endif
                             </select>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="fa-solid fa-floppy-disk me-1"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // Auto-dismiss alert
    setTimeout(() => {
        const alert = document.getElementById("success-alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>

@endsection
