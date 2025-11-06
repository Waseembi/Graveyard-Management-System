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

<div class="container py-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="text-center mb-3">📩 Enter Verification Code</h5>
            <form method="POST" action="{{ route('password.checkCode') }}">
                @csrf
                <div class="mb-3">
                    <label>Code</label>
                    <input type="text" name="code" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success w-100">Verify</button>
            </form>
        </div>
    </div>
</div>


<script>
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
