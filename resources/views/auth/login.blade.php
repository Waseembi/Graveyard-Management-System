@extends('layouts.app')

@section('content')
    {{-- success message --}}
    @if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-3 position-fixed top-0 start-50 translate-middle-x"
        style="max-width: 400px; z-index: 1050;">
        {{ session('success') }}
    </div>
    @endif
    {{-- error message --}}
    @if(session('error'))
        <div id="error-alert" class="alert alert-danger text-center mx-auto mt-3 position-fixed top-0 start-50 translate-middle-x"
        style="max-width: 400px; z-index: 1050;">
        {{ session('error') }}
    </div>
    @endif

<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light ">
    <div class="card border-0 shadow-lg rounded-4 " style="max-width: 420px; width: 100%; margin-top: -3%;">
        <div class="card-body p-4">

            <!-- Circular Logo -->
            <div class="text-center mb-2">
                <img src="{{ asset('websiteimages/loginlogo.jpeg') }}" 
                     alt="GMS Logo" 
                     class="img-fluid shadow-sm"
                     style="width: 70px; height: 70px; border-radius: 50%; border: 3px solid #eaeaea; object-fit: cover;">
            </div>

            <h4 class="text-center mb-3 fw-bold text-dark">
                Welcome to <span class="text-success">Attock GMS</span>
            </h4>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-envelope-fill text-success"></i>
                        </span>
                        <input type="email" name="email" class="form-control border-start-0" 
                               placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold text-muted">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-lock-fill text-success"></i>
                        </span>
                        <input type="password" name="password" id="password" 
                               class="form-control border-start-0" placeholder="••••••••" required>
                        <button type="button" class="btn btn-outline-light border" onclick="togglePassword()" style="border: none;">
                            <i class="bi bi-eye-fill text-muted" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-success w-100 fw-semibold mt-3 py-2 shadow-sm">
                    Login
                </button>
            </form>

            <div class="text-center mt-3">
                <small class="text-muted">Don't have an account? 
                    <a href="{{ route('register') }}" class="text-success fw-semibold">Register</a>
                </small>
            </div>
            <div class="text-center mt-1">
                <small>
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-muted">Forgot Password?</a>
                </small>
            </div>

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

// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('#success-alert, #error-alert').forEach(alert => {
        alert.classList.add('fade');
        setTimeout(() => alert.remove(), 400);
    });
}, 4000);
</script>
@endsection
