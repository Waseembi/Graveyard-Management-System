@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-4">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-success mb-0">
                <i class="bi bi-journal-text me-2"></i>View Registration
            </h4>
            <a href="{{ route('user.records') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
            
        </div>

        <!-- Registration Details Card -->
        <div class="card shadow-sm border-0 rounded-4 p-4">

            <div class="row mb-3">
                <div class="col-md-6"><strong>Name:</strong> {{ $registration->name ?? '-' }}</div>
                <div class="col-md-6"><strong>Father Name:</strong> {{ $registration->father_name ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>CNIC:</strong> {{ $registration->cnic ?? '-' }}</div>
                <div class="col-md-6"><strong>Age:</strong> {{ $registration->age ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Gender:</strong> {{ ucfirst($registration->gender ?? '-') }}</div>
                <div class="col-md-6"><strong>Date of Birth:</strong> {{ $registration->dob ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $registration->status == 'approved' ? 'success' : 'warning' }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </div>
                <div class="col-md-6"><strong>Registered On:</strong> {{ $registration->created_at->format('d M Y') }}</div>
            </div>

        </div>

    </div>
</div>
@endsection
