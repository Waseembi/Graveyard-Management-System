@extends('layouts.app')

@section('content')

<style>
    body {
        background: linear-gradient(135deg, #e9f7ef, #ffffff);
        font-family: 'Poppins', sans-serif;
    }

    .register-card {
        backdrop-filter: blur(12px);
        background: rgba(255, 255, 255, 0.9);
        border-radius: 20px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease-in-out;
    }

    .register-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
    }

    .input-group-text {
        border: none;
        background: #f9f9f9;
    }

    .form-control {
        border: none;
        background: #f9f9f9;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.05);
    }

    .form-control:focus {
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.2);
        background: #fff;
    }

    .btn-success {
        background: #198754;
        border: none;
        transition: all 0.3s ease-in-out;
    }

    .btn-success:hover {
        background: #157347;
        transform: translateY(-2px);
    }

    .logo-container img {
        width: 75px;
        height: 75px;
        border-radius: 50%;
        border: 3px solid #e0e0e0;
        background: white;
        object-fit: cover;
    }

    .fade {
        opacity: 0;
        transition: opacity 0.5s ease;
    }
</style>
{{-- error message --}}
    @if($errors->any())
        <div id="error-alert" 
         class="alert alert-danger text-center mx-auto position-fixed top-0 start-50 translate-middle-x py-1" 
            style="max-width: 400px; z-index: 1050; margin-top: 6%; font-size: 0.9rem; line-height: 1.7;">
            {{ $errors->first() }}
        </div>
    @endif

<div class="d-flex justify-content-center align-items-center min-vh-100">
    <div class="register-card p-4 shadow-sm" style="width: 100%; max-width: 450px;  margin-top: 3%;">
        
        <!-- Logo -->
        <div class="text-center mb-3 logo-container">
            <img src="{{ asset('websiteimages/loginlogo.jpeg') }}" alt="Attock GMS Logo" class="shadow-sm">
        </div>

        <!-- Title -->
        <h3 class="text-center fw-bold mb-2 text-dark">Create Your Account</h3>
            <p class="text-center text-muted mb-4">
            Join <span class="text-success fw-semibold">Attock GMS</span> and manage records effortlessly.
            </p>

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted" >Full Name</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person-fill text-success"></i></span>
                    <input type="text" name="name" class="form-control" placeholder="Your full name" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill text-success"></i></span>
                    <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill text-success"></i></span>
                    <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
                    <button type="button" class="btn btn-light border" onclick="togglePassword()" style="border: none;">
                        <i class="bi bi-eye-fill text-muted" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill text-success"></i></span>
                    <input type="password" name="password_confirmation" id="confirmPassword" class="form-control" placeholder="••••••••" required>
                    
                </div>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-semibold mt-3 py-2 rounded-3">
                Register
            </button>
        </form>

        <div class="text-center mt-3">
            <small class="text-muted">
                Already have an account?
                <a href="{{ route('login') }}" class="text-success fw-semibold">Login here</a>
            </small>
        </div>
    </div>
</div>

<script>

function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
    } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
    }
}

//fade success and error messages after 4 seconds
setTimeout(() => {
    document.querySelectorAll('#success-alert, #error-alert').forEach(alert => {
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 400);
    });
}, 4000);

</script>
@endsection
