@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-4">

        {{-- Page Header --}}
        <h4 class="fw-bold text-success mb-4">
            <i class="fa-solid fa-leaf me-2"></i> Add Burial Record
        </h4>

        {{-- Search Form --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <form action="{{ route('admin.burials.search') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="query" class="form-control rounded-pill shadow-sm"
                           placeholder="Search by Registration ID, CNIC, or Name" required>
                    <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm">
                        <i class="fa-solid fa-search me-1"></i> Search
                    </button>
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
                    <p><strong>Name:</strong> {{ $registration->name }}</p>
                    <p><strong>Father Name:</strong> {{ $registration->father_name }}</p>
                    <p><strong>CNIC:</strong> {{ $registration->cnic }}</p>
                    <p><strong>Registration ID:</strong> {{ $registration->id }}</p>
                    <p><strong>Status:</strong> 
                        <span class="badge rounded-pill {{ $registration->status == 'approved' ? 'bg-success' : 'bg-warning text-dark' }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </p>
                    <p><strong>Burial Status:</strong> 
                        <span class="badge rounded-pill {{ $registration->burial_status == 'buried' ? 'bg-dark text-white' : 'bg-secondary' }}">
                            {{ ucfirst($registration->burial_status) }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Burial Form --}}
            @if($registration->status == 'approved' && $registration->burial_status == 'not_buried')
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <form action="{{ route('admin.burials.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="registration_id" value="{{ $registration->id }}">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-success">Date of Death</label>
                                <input type="date" name="date_of_death" class="form-control rounded-pill shadow-sm" required>
                            </div>
                            <div class="text-end">
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
    .card { border-radius: 12px !important; }
    .badge { font-size: 0.85rem; padding: 6px 12px; }
</style>
@endsection
