@extends('layouts.app')

@section('content')

{{-- Error Message --}}
@if($errors->any())
    <div id="error-alert" 
         class="alert alert-danger text-center mx-auto position-fixed top-0 start-50 translate-middle-x py-1" 
         style="max-width: 400px; z-index: 1050; margin-top: 6%; font-size: 0.9rem; line-height: 1.7;">
        {{ $errors->first() }}
    </div>
@endif

<div class="d-flex justify-content-center align-items-center min-vh-100 mb-5" style="background: linear-gradient(135deg, #e9f7ef, #ffffff); font-family: 'Poppins', sans-serif;">

    <div class="p-4 shadow-lg bg-white rounded-4" style="width: 100%; max-width: 450px; margin-top: 3%; backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.9); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);">
        
        <!-- Logo -->
        <div class="text-center " style="margin-top: -4%">
            <img src="{{ asset('images/logogms-removebg.png') }}" alt="Attock GMS Logo" class=""
                 style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover;">
        </div>

        <!-- Title -->
        <h3 class="text-center fw-bold mb-1 text-dark" style="margin-top: -1%">Create Your Account</h3>
        <p class="text-center text-muted mb-4">
            Join <span class="text-success fw-semibold">Attock GMS</span> and manage records effortlessly.
        </p>

        <!-- Register Form -->
        
            <form method="POST" action="{{ route('register.submit') }}">
{{-- <form method="POST" action="{{ route('register') }}"> --}}
            @csrf

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted" style="font-size: 0.92rem;">Full Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-person-fill text-success"></i></span>
                    <input type="text" name="name" class="form-control  border-start-0 shadow-sm-sm" placeholder="Your full name" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted" style="font-size: 0.92rem;">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope-fill text-success"></i></span>
                    <input type="email" name="email" class="form-control  border-start-0 shadow-sm-sm" placeholder="you@example.com" value="{{ old('email') }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold text-muted" style="font-size: 0.92rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock-fill text-success"></i></span>
                    <input type="password" name="password" id="password" class="form-control  shadow-sm-sm border-start-0" placeholder="••••••••" required>
                    <button type="button" class="btn btn-outline-light border" onclick="togglePassword()" style="border: none;">
                        <i class="bi bi-eye-fill text-muted" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <div class="mb-2 ">
                <label class="form-label fw-semibold text-muted" style="font-size: 0.92rem;">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-lock-fill text-success"></i></span>
                    <input type="password" name="password_confirmation" id="confirmPassword" class="form-control  border-start-0 shadow-sm-sm" placeholder="••••••••" required>
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

setTimeout(() => {
    document.querySelectorAll('#success-alert, #error-alert').forEach(alert => {
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 400);
    });
}, 4000);
</script>
@endsection
