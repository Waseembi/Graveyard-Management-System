@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: -40px;">
            <h4 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-cross me-2"></i>Burial Request
            </h4>
            <a href="{{ route('burial.request.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4 p-4">
            <form method="POST" action="{{ route('burial.request.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $registration->user_id }}">
                <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                <div class="row g-4">
                    <!-- Left Column: Person Info -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-user me-2"></i>Name</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $registration->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-user-tie me-2"></i>Father Name</label>
                            <input type="text" class="form-control rounded-pill " value="{{ $registration->father_name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-success">Date of Death</label>
                            <input type="date" name="date_of_death" class="form-control rounded-pill shadow-sm"  max="{{ date('Y-m-d') }}" required>
                        </div>

                        
                    </div>

                    <!-- Right Column: Burial Info -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-calendar me-2"></i>Date of Birth</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $registration->dob }}" disabled>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-id-card me-2"></i>CNIC</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $registration->cnic ?? 'N/A' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-file me-2"></i>Death Certificate</label>
                            <input type="file" name="death_certificate" class="form-control rounded-pill" required>
                        </div>


                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success px-4 rounded-pill shadow-sm">
                                <i class="fa-solid fa-check me-1"></i>Submit Request
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
        background-color: #f5fdf9;
    }
    .card {
        transition: 0.3s;
    }
    .form-control, .form-select {
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
    .btn-outline-secondary:hover {
        background-color: #e6e6e6;
    }
</style>
@endsection
