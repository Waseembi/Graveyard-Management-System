@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <h4 class="mb-3">Family Member Details</h4>

        <div class="card shadow-sm border-0">
            <div class="card-body">

                <p><strong>Name:</strong> {{ $member->name }}</p>

                <p><strong>Father Name:</strong> {{ $member->father_name }}</p>

                <p><strong>Relation:</strong> {{ $member->relationship }}</p>

                <p><strong>Age:</strong>
                    {{ $member->age ?? '-' }}
                </p>

                <p><strong>CNIC:</strong>
                    @if($member->cnic)
                        {{ $member->cnic }}
                    @else
                        <span class="text-muted">NULL</span>
                    @endif
                </p>

                <p><strong>DOB:</strong>
                    {{ $member->dob ?? '-' }}
                </p>

                <p><strong>Gender:</strong>
                    {{ $member->gender ? ucfirst($member->gender) : '-' }}
                </p>

                {{-- Optional Burial Status --}}
                <p><strong>Burial Status:</strong>
                    @if($member->registration)
                        <span class="badge bg-{{ $member->registration->burial_status === 'completed' ? 'success' : 'secondary' }}">
                            {{ ucfirst($member->registration->burial_status ?? 'Pending') }}
                        </span>
                    @else
                        <span class="text-muted">NULL</span>
                    @endif
                </p>

                
                <a href="{{ route('user.records') }}#family" class="btn btn-secondary mt-3">
    <i class="bi bi-arrow-left"></i> Back
</a>


            </div>
        </div>

    </div>
</div>


@endsection
