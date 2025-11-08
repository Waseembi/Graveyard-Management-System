@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-evergreen">Search Graves</h2>
        <p class="text-sand fs-5">Enter the deceased's name to find grave details quickly.</p>
    </div>

    <!-- Simple Search Form -->
    <form method="GET" action="{{ route('grave.search') }}" class="mx-auto" style="max-width: 600px;">
        <div class="input-group rounded-pill overflow-hidden border border-2 border-evergreen shadow-sm">
            <input type="text" name="name" class="form-control border-0 px-4 py-3 text-evergreen fw-semibold" placeholder="e.g. Syed Haider Zaidi" required>
            <button type="submit" class="btn btn-evergreen fw-bold px-4">Search</button>
        </div>
    </form>

    <!-- Search Results -->
    @if(isset($results))
    <div class="mt-5">
        <h4 class="text-evergreen mb-3">Grave Listings</h4>

        @if(count($results))
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover mb-0">
                <thead class="table-evergreen text-sand">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Father's Name</th>
                        <th>Age</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($results as $record)
                    <tr>
                        <td class="text-evergreen fw-semibold">{{ $record->id }}</td>
                        <td class="text-evergreen fw-semibold">{{ $record->name }}</td>
                        <td class="text-sand">{{ $record->father_name }}</td>
                        <td class="text-sand">{{ $record->age }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-sand mt-3">No records found for "<strong>{{ request('name') }}</strong>".</p>
        @endif
    </div>
    @endif

</div>
@endsection

<style>
/* Theme Colors */
.text-evergreen {
    color: #344C3D !important;
}
.text-sand {
    color: #8e9b8a !important;
}

/* Button */
.btn-evergreen {
    background-color: #344C3D;
    color: #BFCFBB;
    border-radius: 50px;
    transition: all 0.3s ease;
}
.btn-evergreen:hover {
    background-color: #2a3b2e;
    color: #fff;
}

/* Input */
.input-group input.form-control {
    border: none;
    border-radius: 0;
}
.input-group input.form-control:focus {
    box-shadow: none;
    outline: none;
}

/* Table */
.table-evergreen {
    background-color: #344C3D;
}
.table-hover tbody tr:hover {
    background-color: #f0f4ef;
}
.table th, .table td {
    vertical-align: middle;
    border-top: none;
}
.table {
    border: none;
    border-radius: 8px;
    overflow: hidden;
}
</style>
