@extends('layouts.adminapp')

@section('content')

<div class="content" id="mainContent">
    <div class="container-fluid py-4">
        <h4 class="fw-semibold text-dark mb-4">
            <i class="fa-solid fa-receipt me-2 text-primary"></i>Add Burial Record
        </h4>

        {{-- Search Form --}}
        <form action="{{ route('admin.burials.search') }}" method="GET" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="query" class="form-control" placeholder="Search by Registration ID, CNIC, or Name" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary w-100">
                        <i class="fa-solid fa-search me-1"></i>Search
                    </button>
                </div>
            </div>
        </form>

        {{-- Display User Info --}}
        @if(isset($registration))
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold text-dark mb-3">Registration Details</h5>
                    <div class="row mb-2"><div class="col-4 text-muted">Name</div><div class="col-8">{{ $registration->name }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Father Name</div><div class="col-8">{{ $registration->father_name }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">CNIC</div><div class="col-8">{{ $registration->cnic }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Registration ID</div><div class="col-8">{{ $registration->id }}</div></div>
                    <div class="row mb-2"><div class="col-4 text-muted">Status</div><div class="col-8">
                        <span class="badge {{ $registration->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
                            {{ ucfirst($registration->status) }}
                        </span>
                    </div></div>
                </div>
            </div>

            {{-- Burial Form --}}
            @if($registration->status == 'approved')
                <form action="{{ route('admin.burials.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                    <div class="mb-3">
                        <label class="form-label">Date of Death</label>
                        <input type="date" name="date_of_death" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fa-solid fa-plus me-1"></i>Add to Burial
                        </button>
                    </div>
                </form>
            @else
                <div class="alert alert-warning">This user is not approved for burial.</div>
            @endif
        @elseif(request()->has('query'))
            <div class="alert alert-danger">No registration found for your search.</div>
        @endif
    </div>
</div>

@endsection
