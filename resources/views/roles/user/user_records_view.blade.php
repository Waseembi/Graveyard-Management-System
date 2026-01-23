@extends('layouts.userapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-4">

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

 {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger text-center mx-auto mt-5" style="
            position: absolute;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            max-width: 400px;
            z-index: 1050;
            box-shadow: 0 0.5rem 1rem rgba(128, 0, 0, 0.2);
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            line-height: 1.3;
        ">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li style="list-style-type: none">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
{{-- Error message --}}
@if(session('error'))
    <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        box-shadow: 0 0.5rem 1rem rgba(255, 0, 0, 0.2);
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.95rem;
        padding: 0.5rem 1rem;
        line-height: 1.3;
    ">      
        {{ session('error') }}
    </div>
@endif

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-success mb-0">
                <i class="bi bi-journal-text me-2"></i>View Registration
            </h4>
            <a href="{{ route('user.records') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Back
            </a>
            
        </div>

        <!-- Registration Details Card -->
        <div class="card shadow-sm border-0 rounded-4 p-4">

            <div class="row mb-3">
                <div class="col-md-6"><strong>Name:</strong> {{ $registration->name ?? '-' }}</div>
                <div class="col-md-6"><strong>Father Name:</strong> {{ $registration->father_name ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>CNIC:</strong> {{ $registration->cnic ?? '-' }}</div>
                <div class="col-md-6"><strong>Age:</strong> {{ $registration->age ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Gender:</strong> {{ ucfirst($registration->gender ?? '-') }}</div>
                <div class="col-md-6"><strong>Date of Birth:</strong> {{ $registration->dob ?? '-' }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Status:</strong>
                    <span class="badge bg-{{ $registration->status == 'approved' ? 'success' : 'warning' }}">
                        {{ ucfirst($registration->status) }}
                    </span>
                </div>
                <div class="col-md-6"><strong>Registered On:</strong> {{ $registration->created_at->format('d M Y') }}</div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6"><strong>Burial Status:</strong> 
                            <span class="badge bg-{{ $registration->burial_status === 'buried' ? 'black' : 'secondary' }}">
                                {{ ucfirst($registration->burial_status ?? 'Pending') }}
                            </span>
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


<script>
    setTimeout(() => {
        const alert = document.querySelector(".alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
@endsection
