@extends('layouts.app')

@section('content')
{{-- success message --}}
        @if(session('success'))
            <div id="success-alert" class="alert alert-success text-center mx-auto mt-3" style="
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
        {{-- Error message --}}
        @if(session('error'))
            <div id="success-alert" class="alert alert-danger text-center mx-auto mt-3" style="
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


<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="card shadow-lg border-0 rounded" style="width: 100%; max-width: 450px;">
        <div class="card-body p-4">
            <h3 class="text-center mb-4 fw-bold text-dark">🔐 Login to Attock GMS</h3>

            {{-- @if($errors->any())
                <div id="successAlert" class="alert alert-danger text-center p-1" >{{ $errors->first() }}</div>
            @endif --}}

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white"><i class="bi bi-envelope-fill"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="you@example.com" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-dark text-white"><i class="bi bi-lock-fill"></i></span>
                        <input type="password" name="password" id="password" class="form-control rounded-start" placeholder="••••••••" required>
                        <span class="input-group-text bg-white border-start-0 rounded-end" onclick="togglePassword()" style="cursor: pointer;">
                            <i class="bi bi-eye-fill" id="toggleIcon"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark w-100 mt-3 fw-bold">Login</button>
            </form>

            <div class="text-center mt-3">
                <small>Don't have an account? <a href="{{ route('register') }}">Register here</a></small>
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

// Auto-dismiss success alert after 4 seconds
setTimeout(() => {
    const alert = document.getElementById("success-alert");
    if (alert) {
        alert.classList.add("fade");
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);
</script>
@endsection
