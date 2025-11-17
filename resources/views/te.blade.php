@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-success mb-0">
                <i class="fa-solid fa-leaf me-2"></i> Add Burial Record
            </h3>
            <a href="{{ route('admin.burials.index') }}" class="btn btn-outline-success rounded-pill shadow-sm">
                <i class="fa-solid fa-database me-1"></i> View Records
            </a>
        </div>

        {{-- Step Indicator --}}
        <div class="d-flex justify-content-center mb-4">
            <div class="stepper d-flex align-items-center">
                <div class="step active">1</div><span class="line"></span>
                <div class="step {{ isset($registration) ? 'active' : '' }}">2</div><span class="line"></span>
                <div class="step {{ isset($registration) && $registration->status == 'approved' ? 'active' : '' }}">3</div>
            </div>
        </div>

        {{-- Search Form --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <form action="{{ route('admin.burials.search') }}" method="GET">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-8">
                            <input type="text" name="query" class="form-control rounded-pill shadow-sm"
                                   placeholder="Search by Registration ID, CNIC, or Name" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-success w-100 rounded-pill shadow-sm">
                                <i class="fa-solid fa-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Registration Details --}}
        @if(isset($registration))
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-success text-white fw-semibold rounded-top">
                    Registration Details
                </div>
                <div class="card-body">
                    <div class="row mb-2"><div class="col-4 text-muted">Name</div><div class="col-8 fw-semibold">{{ $registration->name }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Father Name</div><div class="col-8">{{ $registration->father_name }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">CNIC</div><div class="col-8">{{ $registration->cnic }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Registration ID</div><div class="col-8">{{ $registration->id }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Status</div><div class="col-8">
                        <span class="badge rounded-pill {{ $registration->status == 'approved' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Burial Status</div><div class="col-8">
                        <span class="badge rounded-pill {{ $registration->burial_status == 'buried' ? 'bg-dark text-white' : 'bg-secondary' }}">
                            {{ ucfirst($registration->burial_status) }}
                        </span>
                    </div></div>
                </div>
            </div>

            {{-- Burial Form --}}
            @if($registration->status == 'approved' && $registration->burial_status == 'not_buried')
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-success text-white fw-semibold rounded-top">
                        Burial Information
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.burials.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-success">Date of Death</label>
                                <input type="date" name="date_of_death" class="form-control rounded-pill shadow-sm" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                                    <i class="fa-solid fa-plus me-1"></i> Add to Burial
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @elseif($registration->burial_status == 'buried')
                <div class="alert alert-info rounded-pill shadow-sm">This user is already buried.</div>
            @elseif($registration->status != 'approved')
                <div class="alert alert-warning rounded-pill shadow-sm">This user is not approved for burial.</div>
            @endif

        @elseif(request()->has('query'))
            <div class="alert alert-danger rounded-pill shadow-sm">No registration found for your search.</div>
        @endif
    </div>
</div>

{{-- Green Theme Styling --}}
<style>
    .stepper .step {
        width: 35px; height: 35px;
        border-radius: 50%;
        background: #e8f5e9;
        color: #2e7d32;
        display: flex; align-items: center; justify-content: center;
        font-weight: 600;
    }
    .stepper .step.active {
        background: #2e7d32;
        color: #fff;
    }
    .stepper .line {
        width: 50px; height: 3px;
        background: #c8e6c9;
        margin: 0 10px;
    }
    .btn-success {
        background: linear-gradient(135deg, #34c759, #1e8e3e);
        border: none;
    }
    .btn-success:hover {
        background: linear-gradient(135deg, #2e7d32, #145a32);
    }
    .btn-outline-success {
        border-color: #2e7d32;
        color: #2e7d32;
    }
    .btn-outline-success:hover {
        background-color: #2e7d32;
        color: #fff;
    }
    .card { border-radius: 15px !important; }
    .badge { font-size: 0.85rem; padding: 6px 12px; }
</style>
@endsection
