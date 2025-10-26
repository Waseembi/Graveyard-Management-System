@extends('layouts.userapp')

@section('content')

<style>
    body {
        background: linear-gradient(to right, #e0f7fa, #f1f8e9);
        font-family: 'Segoe UI', sans-serif;
    }

    .form-container {
        background: white;
        padding: 1.5rem 2rem; /* reduced padding */
        border-radius: 12px;
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        max-width: 750px; /* slightly narrower */
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


<div class="d-flex justify-content-center align-items-start" 
     style="min-height: calc(100vh - 90px); background-color:#f8f9fa; padding-top:90px; 
     margin-left:180px; margin-top: -2%">
     
    <div class="container">
        {{-- success message --}}
        @if(session('success'))
            <div id="success-alert" class="alert alert-success text-center mx-auto" style="
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

        {{-- error message --}}
        @if(session('error'))
            <div id="success-alert" class="alert alert-danger text-center mx-auto" style="
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

        <div class="form-container mt-3">
            <h2 class="mb-4 text-center text-success">🪦 Graveyard Registration Form</h2>

            <form action="{{ route('user.register.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-person-fill"></i> Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-person-badge-fill"></i> Father Name</label>
                        <input type="text" name="father_name" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-credit-card-2-front-fill"></i> CNIC (optional)</label>
                        <input type="text" name="cnic" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-telephone-fill"></i> Phone Number</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-calendar-heart-fill"></i> Age</label>
                        <input type="number" name="age" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="bi bi-wallet-fill"></i> Payment Method</label>
                        <select name="payment_method" class="form-select" required>
                            <option value="">Select</option>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Address</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 py-2">
                        <i class="bi bi-send-fill"></i> Submit Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-dismiss success/error alert after 4 seconds
    setTimeout(() => {
        const alert = document.getElementById("success-alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
@endsection
