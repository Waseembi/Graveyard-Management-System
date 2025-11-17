@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-success mb-1">
                    <i class="fa-solid fa-leaf me-2 text-success"></i> Burial Records
                </h3>
                <p class="text-muted mb-0">Manage and review all burial records efficiently</p>
            </div>
            <a href="{{ route('admin.burials.add') }}" class="btn btn-success shadow-sm rounded-pill px-3">
                <i class="fa-solid fa-plus me-1"></i> Add New Burial
            </a>
        </div>

        {{-- Search & Filter Panel --}}
        <div class="card border-0 shadow-sm mb-4 rounded-4">
            <div class="card-body">
                <form action="{{ route('admin.burials.index') }}" method="GET">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-success">Name</label>
                            <input type="text" name="name" class="form-control shadow-sm rounded-pill" placeholder="e.g. Waseem Afridi" value="{{ request('name') }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold text-success">CNIC</label>
                            <input type="text" name="cnic" class="form-control shadow-sm rounded-pill" placeholder="e.g. 35202-XXXXXXX-X" value="{{ request('cnic') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-success">Grave ID</label>
                            <input type="text" name="grave_id" class="form-control shadow-sm rounded-pill" placeholder="e.g. 12" value="{{ request('grave_id') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label fw-semibold text-success">Year of Death</label>
                            <input type="number" name="year" class="form-control shadow-sm rounded-pill" placeholder="e.g. 2025" value="{{ request('year') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-success w-100 shadow-sm rounded-pill">
                                <i class="fa-solid fa-search me-1"></i> Search
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Active Filters --}}
        @if(request()->hasAny(['name', 'cnic', 'grave_id', 'year']))
            <div class="alert alert-success border-0 shadow-sm rounded-pill">
                <strong><i class="fa-solid fa-filter me-2"></i>Filters Applied:</strong>
                @if(request('name')) <span class="badge rounded-pill bg-light text-success me-1">Name: {{ request('name') }}</span> @endif
                @if(request('cnic')) <span class="badge rounded-pill bg-light text-success me-1">CNIC: {{ request('cnic') }}</span> @endif
                @if(request('grave_id')) <span class="badge rounded-pill bg-light text-success me-1">Grave ID: {{ request('grave_id') }}</span> @endif
                @if(request('year')) <span class="badge rounded-pill bg-light text-success me-1">Year: {{ request('year') }}</span> @endif
            </div>
        @endif

        {{-- Burial Records Table --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-database me-2"></i> Record List
                </h5>
                <small>Total Records: {{ $burials->count() }}</small>
            </div>

            <div class="card-body table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="bg-light text-success">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>CNIC</th>
                            <th>Date of Death</th>
                            <th>Grave ID</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($burials as $index => $burial)
                            <tr class="hover-row">
                                <td class="fw-semibold text-muted">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $burial->name }}</td>
                                <td>{{ $burial->father_name }}</td>
                                <td class="text-muted">{{ $burial->registration->cnic ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-success px-3 py-2">
                                        {{ \Carbon\Carbon::parse($burial->date_of_death)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        {{ $burial->grave->id ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge px-3 py-2 rounded-pill {{ 
                                        $burial->registration->burial_status === 'buried' 
                                            ? 'bg-success text-white' 
                                            : 'bg-warning text-dark'
                                    }}">
                                        {{ ucfirst($burial->registration->burial_status ?? 'Pending') }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-circle-exclamation text-warning me-2"></i>
                                    No burial records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

{{-- Green Theme Styling --}}
<style>
    .hover-row:hover {
        background-color: #e8f5e9 !important; /* soft green hover */
        transform: scale(1.01);
        transition: all 0.2s ease-in-out;
    }

    .table thead th {
        vertical-align: middle !important;
        font-weight: 600;
    }

    .badge {
        border-radius: 12px;
        font-size: 0.85rem;
    }

    .card {
        border-radius: 15px !important;
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
</style>
@endsection
