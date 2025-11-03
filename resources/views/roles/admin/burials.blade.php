@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-4">
        <h4 class="fw-semibold text-dark mb-4">
            <i class="bi bi-people me-2 text-primary"></i>Burial Records
        </h4>

        <form action="{{ route('admin.burials.index') }}" method="GET" class="mb-4">
           <div class="row g-3">
               <div class="col-md-3">
                   <input type="text" name="name" class="form-control" placeholder="Search by Name" value="{{ request('name') }}">
               </div>
               <div class="col-md-3">
                  <input type="text" name="cnic" class="form-control" placeholder="Search by CNIC" value="{{ request('cnic') }}">
                </div>
               <div class="col-md-2">
                   <input type="text" name="grave_id" class="form-control" placeholder="Grave ID" value="{{ request('grave_id') }}">
                </div>
               <div class="col-md-2">
                    <input type="number" name="year" class="form-control" placeholder="Year of Death" value="{{ request('year') }}">
               </div>
               <div class="col-md-2">
                  <button type="submit" class="btn btn-outline-primary w-100">
                     <i class="fa-solid fa-search me-1"></i>Search
                  </button>
                </div>
            </div>
        </form>



        @if(request()->hasAny(['name', 'cnic', 'grave_id', 'year']))
            <p class="text-muted">
                Showing results for:
                @if(request('name')) <strong>Name:</strong> {{ request('name') }} @endif
                @if(request('cnic')) <strong>CNIC:</strong> {{ request('cnic') }} @endif
                @if(request('grave_id')) <strong>Grave ID:</strong> {{ request('grave_id') }} @endif
                @if(request('year')) <strong>Year:</strong> {{ request('year') }} @endif
            </p>
        @endif



        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
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
                        @forelse($burials as $index => $burial)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $burial->name }}</td>
                                <td>{{ $burial->father_name }}</td>
                                <td>{{ $burial->registration->cnic ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($burial->date_of_death)->format('d M Y') }}</td>
                                <td>{{ $burial->grave->id ?? 'N/A' }}</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No burial records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
