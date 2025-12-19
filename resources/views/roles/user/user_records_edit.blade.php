@extends('layouts.userapp')

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
                <h4 class="fw-bold text-success"><i class="bi bi-pencil-square me-2"></i>Edit Registration</h4>
                <p class="text-muted mb-0">Modify registration details.</p>
            </div>
            
            <a href="{{ route('user.records') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Update Form Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold text-dark">Edit Details</h6>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('user.registration.update', $registration->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Name</label>
                            <input type="text" name="name" value="{{ old('name', $registration->name) }}" class="form-control shadow-sm" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Father Name</label>
                            <input type="text" name="father_name" value="{{ old('father_name', $registration->father_name) }}" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CNIC</label>
                            <input type="text" name="cnic" value="{{ old('cnic', $registration->cnic) }}" class="form-control shadow-sm" placeholder="Optional">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Age</label>
                            <input type="number" name="age" value="{{ old('age', $registration->age) }}" class="form-control shadow-sm" min="0">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select shadow-sm">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $registration->gender)=='male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $registration->gender)=='female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"><i class="bi bi-calendar-date-fill"></i> Date of Birth</label>
                            <input type="date" name="dob" max="{{ date('Y-m-d') }}" required value="{{ old('dob', $registration->dob) }}" class="form-control shadow-sm">
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Address</label>
                            <input type="text" name="address" value="{{ old('address',      $registration->address) }}" class="form-control shadow-sm" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-check-circle me-1"></i> Update
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>

@endsection
