
@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-3 text-dark">Search Grave</h2>
    <p class="text-center text-muted mb-4">Enter the name of the deceased to find grave details</p>

    <!-- Search Form -->
    <form method="GET" action="{{ route('grave.search') }}" class="bg-white p-4 rounded shadow-sm border">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <label for="name" class="form-label fw-semibold text-dark">Name of Deceased</label>
                <div class="input-group">
                    <input type="text" name="name" id="name" class="form-control border-dark" placeholder="e.g. Syed Haider Zaidi">
                    <button type="submit" class="btn btn-dark px-4">Search</button>
                </div>
            </div>
        </div>
    </form>

    <!-- Search Results -->
    @if(isset($results))
    <div class="mt-5">
        <h4 class="text-dark mb-3">Grave Listings</h4>
        @if(count($results))
        <div class="table-responsive">
            <table class="table table-bordered table-hover bg-white">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Father's Name</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $index => $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->name }}</td>
                        <td>{{ $record->father_name }}</td>
                        <td>{{ $record->age }}</td>
                        {{-- <td>
                            <a href="{{ route('records.show', $record->id) }}" class="btn btn-sm btn-outline-dark">View</a>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-muted">No records found for "{{ request('name') }}".</p>
        @endif
    </div>
    @endif
</div>
@endsection 
