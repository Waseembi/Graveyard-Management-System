@extends('layouts.app')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #f1f8e9);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: auto;
    }

    .form-label i {
        margin-right: 6px;
        color: #00796b;
    }

    .alert {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="container mt-5">
        {{-- success message --}}
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
                box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
                line-height: 1.3;
            ">      
                 {{ session('error') }}
        </div>
        @endif

    <div class="form-container mt-4 mb-5">
        <h2 class="mb-4 text-center text-success">🪦 Graveyard Registration Form</h2>

        <form action="{{ route('registration.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-person-fill"></i> Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-person-badge-fill"></i> Father Name</label>
                    <input type="text" name="father_name" value="{{ old('father_name') }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-credit-card-2-front-fill"></i> CNIC (optional)</label>
                    <input type="text" name="cnic" value="{{ old('cnic') }}" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-telephone-fill"></i> Phone Number</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-heart-fill"></i> Age</label>
                    <input type="number" value="{{ old('age') }}" name="age" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-date-fill"></i> Date of Birth</label>
                    <input type="date" name="dob" value="{{ old('dob') }}" class="form-control"  max="{{ date('Y-m-d') }}"required>
                </div>        
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-gender-ambiguous"></i> Gender</label>
                        <select name="gender" class="form-select" required>
                            <option value="">Select</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-wallet-fill"></i> Payment Method</label>
                    <select name="payment_method" class="form-select" required>
                        <option value="">Select</option>
                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Card</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Address</label>
                <textarea name="address"  class="form-control" rows="3" required>{{ old('address') }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bi bi-send-fill"></i> Submit Registration
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Bootstrap Icons CDN --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<script>
    setTimeout(() => {
        const alert = document.querySelector(".alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 700);
        }
    }, 4000);
</script>
@endsection
