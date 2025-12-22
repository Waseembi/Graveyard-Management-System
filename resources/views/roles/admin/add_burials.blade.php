@extends('layouts.adminapp')

@section('content')

{{-- Success Message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    ">      
        {{ session('success') }}
    </div>
@endif

<div class="content" id="mainContent">
<div class="container-fluid py-3">

    {{-- Header --}}
    <div class="mb-4">
        <h3 class="fw-bold text-success">
            <i class="fa-solid fa-leaf me-2"></i> Add Burial Record
        </h3>
        <p class="text-muted">Search approved user and assign burial</p>
    </div>

    {{-- Search Panel --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.burials.search') }}">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-success">Name</label>
                        <input type="text" name="name" class="form-control rounded-pill shadow-sm"
                               value="{{ request('name') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold text-success">Father Name</label>
                        <input type="text" name="father_name" class="form-control rounded-pill shadow-sm"
                               value="{{ request('father_name') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold text-success">CNIC</label>
                        <input type="text" name="cnic" class="form-control rounded-pill shadow-sm"
                               value="{{ request('cnic') }}">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-outline-success w-100 rounded-pill shadow-sm">
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Registration Details --}}
    @if(isset($registration))
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-header bg-success text-white fw-semibold rounded-top">
                Registration Details
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $registration->name }}</p>
                <p><strong>Father Name:</strong> {{ $registration->father_name }}</p>
                <p><strong>CNIC:</strong> {{ $registration->cnic }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge rounded-pill {{ $registration->status === 'approved' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </p>
                <p>
                    <strong>Burial Status:</strong>
                    <span class="badge rounded-pill {{ $registration->burial_status === 'buried' ? 'bg-dark' : 'bg-secondary' }}">
                        {{ ucfirst($registration->burial_status) }}
                    </span>
                </p>
            </div>
        </div>

        {{-- Burial Form --}}
        @if($registration->status === 'approved' && $registration->burial_status === 'not_buried')
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.burials.store') }}">
                        @csrf
                        <input type="hidden" name="registration_id" value="{{ $registration->id }}">

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-success">Date of Death</label>
                            <input type="date" name="date_of_death"
                                   class="form-control rounded-pill shadow-sm" required>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-success rounded-pill px-4 shadow-sm">
                                <i class="fa-solid fa-plus me-1"></i> Add Burial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($registration->status !== 'approved')
            <div class="alert alert-warning rounded-pill shadow-sm mt-3">
                <i class="fa-solid fa-exclamation-circle me-2"></i>
                This user is not approved for burial.
            </div>
        @elseif($registration->burial_status === 'buried')
            <div class="alert alert-info rounded-pill shadow-sm mt-3">
                <i class="fa-solid fa-check-circle me-2"></i>
                This user is already buried.
            </div>
        @endif

    @elseif(request()->hasAny(['name','father_name','cnic']))
        <div class="alert alert-danger rounded-pill shadow-sm mt-3">
            <i class="fa-solid fa-circle-exclamation me-2"></i>
            No registration found for your search.
        </div>
    @endif

</div>
</div>

{{-- Styles --}}
<style>
    .card { border-radius: 15px !important; }
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
    .badge {
        font-size: 0.85rem;
        padding: 6px 12px;
    }
</style>

{{--  Scripts --}}
<script>
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
@endsection
