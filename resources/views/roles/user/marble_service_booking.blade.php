@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent" >
    <div class="container-fluid py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4" style="margin-top: -40px;">
            <h4 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-gem me-2"></i>Book Marble Service
            </h4>
            <a href="{{ route('marble.service.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- Card -->
        <div class="card shadow-lg border-0 rounded-4 p-4">
            <form action="{{ route('marble.service.store', $grave->id) }}" method="POST">
                @csrf

                <div class="row g-4">
                    <!-- Left Column: Burial Info -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-user me-2"></i>Name</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $burial->name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-user-tie me-2"></i>Father Name</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $burial->father_name }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-calendar me-2"></i>Date of Birth</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $burial->registration->dob ?? 'N/A' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-money-bill-wave me-2"></i>Service Fee</label>
                            <input type="text" class="form-control rounded-pill text-danger fw-bold" value="20,000" disabled>
                        </div>

                        
                    </div>


                    <!-- Right Column: Grave & Payment -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-map-marker-alt me-2"></i>Grave ID</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $grave->id }}" disabled>
                        </div>


                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-hourglass-half me-2"></i>Age</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $burial->registration->age ?? 'N/A' }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-cross me-2"></i>Date of Death</label>
                            <input type="text" class="form-control rounded-pill" value="{{ $burial->date_of_death }}" disabled>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold"><i class="fa-solid fa-credit-card me-2"></i>Payment Method</label>
                            <select name="payment_method" class="form-select rounded-pill" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                            </select>
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
    /* .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
    } */
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
