@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark"><i class="bi bi-person-lines-fill me-2 text-success"></i>Family Member Details</h4>
            <a href="{{ route('user.records') }}#family" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Family Member Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold text-dark">
                Family Member Info
            </div>
            <div class="card-body">
                <!-- Details in rows -->
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Name:</strong> {{ $member->name ?? '-' }}</div>
                    <div class="col-md-6"><strong>Father Name:</strong> {{ $member->father_name ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Relation:</strong> {{ ucfirst($member->relationship ?? '-') }}</div>
                    <div class="col-md-6"><strong>Age:</strong> {{ $member->age ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>CNIC:</strong> 
                        @if($member->cnic)
                            {{ $member->cnic }}
                        @else
                            <span class="text-muted">NULL</span>
                        @endif
                    </div>
                    <div class="col-md-6"><strong>DOB:</strong> {{ $member->dob ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Gender:</strong> {{ $member->gender ? ucfirst($member->gender) : '-' }}</div>
                    <div class="col-md-6"><strong>Address:</strong> {{ $member->address ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Burial Status:</strong> 
                        @if($member->registration)
                            <span class="badge bg-{{ $member->registration->burial_status === 'completed' ? 'success' : 'secondary' }}">
                                {{ ucfirst($member->registration->burial_status ?? 'Pending') }}
                            </span>
                        @else
                            <span class="text-muted">NULL</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
