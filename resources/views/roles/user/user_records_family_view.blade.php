@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark"><i class="bi bi-person-lines-fill me-2 text-success"></i>Family Member Details</h4>
            <a href="{{ route('user.records') }}#family" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back
            </a>
        </div>

        <!-- Family Member Card -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold text-dark">
                Family Member Info
            </div>
            <div class="card-body">
                <!-- Details in rows -->
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Name:</strong> {{ $member->name ?? '-' }}</div>
                    <div class="col-md-6"><strong>Father Name:</strong> {{ $member->father_name ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Relation:</strong> {{ ucfirst($member->relationship ?? '-') }}</div>
                    <div class="col-md-6"><strong>Age:</strong> {{ $member->age ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>CNIC:</strong> 
                        @if($member->cnic)
                            {{ $member->cnic }}
                        @else
                            <span class="text-muted">NULL</span>
                        @endif
                    </div>
                    <div class="col-md-6"><strong>DOB:</strong> {{ $member->dob ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Gender:</strong> {{ $member->gender ? ucfirst($member->gender) : '-' }}</div>
                    <div class="col-md-6"><strong>Address:</strong> {{ $member->address ?? '-' }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6"><strong>Burial Status:</strong> 
                        @if($member->registration)
                            <span class="badge bg-{{ $member->registration->burial_status === 'completed' ? 'success' : 'secondary' }}">
                                {{ ucfirst($member->registration->burial_status ?? 'Pending') }}
                            </span>
                        @else
                            <span class="text-muted">NULL</span>
                        @endif
                    </div>
                    <div class="col-md-6"><strong>Registered On:</strong> {{ $member->created_at->format('d M Y') }}</div>
                </div>

            </div>
        </div>


          <!-- Payment Records Section -->
    <div class="card shadow-sm border-0 mt-4 mb-4">
        <div class="card-header bg-white">
             <h6 class="mb-0 fw-semibold text-dark">Payment Records</h6>
        </div>
        <div class="card-body table-responsive">
          @if($payments->isEmpty())
            <p class="text-muted mb-0">No payment records found for this user.</p>
         @else
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Year</th>
                        <th>Paid On</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $index => $payment)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ ucfirst($payment->method) }}</td>
                            <td>
                                <span class="badge bg-{{ $payment->status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>{{ $payment->payment_year }}</td>
                            <td>
                                @if($payment->payment_date)
                                    {{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
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
@endsection
