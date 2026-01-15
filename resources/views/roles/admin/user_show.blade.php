@extends('layouts.adminapp')

@section('content')

{{-- Success message --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        line-height: 1.3;
    ">      
        {{ session('success') }}
    </div>
@endif

<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold text-dark"><i class="fa-solid fa-eye me-2 text-info"></i>View User Details</h4>
                <p class="text-muted mb-0">View user profile and related family members.</p>
            </div>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i>Back
            </a>
        </div>

        <!-- User Info Card -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold text-dark">User Information</h6>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Name:</strong> {{ $user->name }}</div>
                    <div class="col-md-6"><strong>Father Name:</strong> {{ $user->father_name }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>CNIC:</strong> {{ $user->cnic }}</div>
                    <div class="col-md-6"><strong>Phone:</strong> {{ $user->phone ?? 'N/A' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Age:</strong> {{ $user->age }}</div>
                    <div class="col-md-6"><strong>Address:</strong> {{ $user->address }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <strong>Status:</strong> 
                        <span class="badge bg-{{ $user->status == 'approved' ? 'success' : 'warning' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                    <div class="col-md-6"><strong>Registered On:</strong> {{ $user->created_at->format('d M Y') }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-md-6 "><strong>Register By:</strong> <strong class="text-danger"> {{ $userRegisterbywhom->name }} </strong></div>
                </div>

            </div>
        </div>

        <!-- Family Members Section -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold text-dark">Family Members</h6>
            </div>
            <div class="card-body table-responsive">
                @if($familyRecord->isEmpty())
                    <p class="text-muted mb-0">No family members found for this registration.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Father Name</th>
                                <th>CNIC</th>
                                <th>Age</th>
                                <th>Address</th>
                                <th>Relationship</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($familyRecord as $index => $member)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->father_name }}</td>
                                    <td>{{ $member->cnic }}</td>
                                    <td>{{ $member->age }}</td>
                                    <td>{{ $member->address }}</td>
                                    <td>{{ $member->relationship ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $member->status == 'approved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($member->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
    // Auto-dismiss alert
    setTimeout(() => {
        const alert = document.getElementById("success-alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>

@endsection
