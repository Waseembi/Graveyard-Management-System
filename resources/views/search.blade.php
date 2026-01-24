@extends('layouts.app')

@section('content')
<div class="text-black text-center py-3 px-4 mb-2  shadow-sm" style="width: 100%;">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
        <div class="fw-semibold fs-6">
            <i class="fa-solid fa-location-dot me-2"></i> Graveyard Location:  M-8 Highway, Baldia Town, Karachi, Pakistan
        </div>
        <a href="https://www.google.com/maps/place/Shamsabad+Shahpur+Graveyard/@24.9351656,66.9432931,17z/data=!3m1!4b1!4m6!3m5!1s0x3eb36b2f6c84d7f3:0x9c07e6d66a256c30!8m2!3d24.9351656!4d66.9432931!16s%2Fg%2F11cm73ksf4?entry=ttu&g_ep=EgoyMDI2MDExMy4wIKXMDSoASAFQAw%3D%3D" 
           target="_blank" 
           class="btn btn-light btn-sm rounded-pill mt-2 mt-md-0">
            <i class="fa-solid fa-location-dot me-1"></i> View on Google Maps
        </a>
    </div>
</div>


<div class="container py-5">

    {{-- Header --}}
    <div class="text-center mb-4">
        <h2 class="fw-bold text-evergreen">Search Graves</h2>
        <p class="text-sand fs-6">Search by name, father name, CNIC, grave ID, or year of death.</p>
    </div>

    {{-- Search Panel --}}
    <div class="card border-0 shadow-sm mb-4 rounded-4 mx-auto">
        <div class="card-body">
            <form method="GET" action="{{ route('grave.search') }}">
                <div class="row g-2 align-items-end">

                    <div class="col-md">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-user"></i></span>
                            <input type="text" name="name" class="form-control rounded-end shadow-sm p-2"
                                   placeholder="Name e.g. Ahmad Ali" value="{{ request('name') }}">
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-user-tie"></i></span>
                            <input type="text" name="father_name" class="form-control rounded-end shadow-sm p-2"
                                   placeholder="Father Name e.g. Khan Sahib" value="{{ request('father_name') }}">
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-id-card"></i></span>
                            <input type="text" name="cnic" class="form-control rounded-end shadow-sm p-2"
                                   placeholder="CNIC e.g. 35202-XXXXXXX-X" value="{{ request('cnic') }}">
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-hashtag"></i></span>
                            <input type="number" name="grave_id" class="form-control rounded-end shadow-sm p-2"
                                   placeholder="Grave ID" value="{{ request('grave_id') }}">
                        </div>
                    </div>

                    <div class="col-md">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-calendar"></i></span>
                            <input type="number" name="year" class="form-control rounded-end shadow-sm p-2"
                                   placeholder="Year of Death" value="{{ request('year') }}">
                        </div>
                    </div>

                    <div class="col-md-auto">
                        <button type="submit" class="btn btn-outline-success shadow-sm rounded-pill px-4 py-2">
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
                            <i class="fa-solid fa-search me-1"></i> Search
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Active Filters --}}
    {{-- @if(request()->hasAny(['name', 'father_name', 'cnic', 'grave_id', 'year']))
        <div class="alert alert-success border-0 shadow-sm rounded-pill">
            <strong><i class="fa-solid fa-filter me-2"></i>Filters Applied:</strong>
            @if(request('name')) 
                <span class="badge rounded-pill bg-light text-success me-1">
                    Name: {{ request('name') }}
                    <a href="{{ url()->current() }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                </span> 
            @endif
            @if(request('father_name')) 
                <span class="badge rounded-pill bg-light text-success me-1">
                    Father Name: {{ request('father_name') }}
                    <a href="{{ url()->current() }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                </span> 
            @endif
            @if(request('cnic')) 
                <span class="badge rounded-pill bg-light text-success me-1">
                    CNIC: {{ request('cnic') }}
                    <a href="{{ url()->current() }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                </span> 
            @endif
            @if(request('grave_id')) 
                <span class="badge rounded-pill bg-light text-success me-1">
                    Grave ID: {{ request('grave_id') }}
                    <a href="{{ url()->current() }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                </span> 
            @endif
            @if(request('year')) 
                <span class="badge rounded-pill bg-light text-success me-1">
                    Year: {{ request('year') }}
                    <a href="{{ url()->current() }}" class="text-danger ms-2"><i class="fa-solid fa-xmark"></i></a>
                </span> 
            @endif
        </div>
    @endif --}}

    {{-- Results --}}
    @if(isset($results))
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top">
                <h5 class="fw-bold mb-0"><i class="fa-solid fa-database me-2"></i> Grave Listings</h5>
                <small>Total Records: {{ $results->count() }}</small>
            </div>

            <div class="card-body table-responsive">
                <table class="table table-striped align-middle table-hover mb-0">
                    <thead class="bg-light text-success">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>CNIC</th>
                            <th>Date of Death</th>
                            <th>Grave ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $index => $record)
                            <tr class="hover-row">
                                <td class="fw-semibold text-muted">{{ $index + 1 }}</td>
                                <td class="fw-bold text-dark">{{ $record->name }}</td>
                                <td>{{ $record->father_name }}</td>
                                <td class="text-muted">{{ optional($record->registration)->cnic ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light text-success px-3 py-2">
                                        {{ \Carbon\Carbon::parse($record->date_of_death)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success px-3 py-2">{{ $record->grave_id }}</span>
                                </td>
                                
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-circle-exclamation text-warning me-2"></i>
                                    No graves found.
                                    <br>
                                    <a href="{{ route('grave.search') }}" class="btn btn-sm btn-outline-success mt-2">Reset Filters</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>

{{-- Styling --}}
<style>
.text-evergreen { color: #344C3D !important; }
.text-sand { color: #8e9b8a !important; }

.btn-outline-success {
    border-color: #2e7d32;
    color: #2e7d32;
    font-weight: 500;
}
.btn-outline-success:hover {
    background-color: #2e7d32;
    color: #fff;
}

/* .hover-row:hover {
    background-color: #e8f5e9 !important;
    transform: scale(1.01);
    transition: all 0.2s ease-in-out;
} */

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

.table {
    border-radius: 10px;
    overflow: hidden;
}

/* Fade-in animation for rows */
tbody tr {
    animation: fadeIn 0.5s ease-in;
}
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

{{-- Script for loading spinner --}}
<script>
document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('loadingSpinner').classList.remove('d-none');
});
</script>
@endsection