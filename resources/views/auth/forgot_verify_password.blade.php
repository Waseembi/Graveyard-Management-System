@extends('layouts.app')
@section('content')
{{-- Success message --}}
@if(session('success'))
    <div id="success-alert" class="alert text-center mx-auto mt-3" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        background-color: #344C3D;
        color: #BFCFBB;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.2);
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
    <div id="error-alert" class="alert text-center mx-auto mt-3" style="
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        max-width: 400px;
        z-index: 1050;
        background-color: #BFCFBB;
        color: #344C3D;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.2);
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
    <div class="card mx-auto shadow-lg rounded-4" style="max-width: 400px; border: none; background: linear-gradient(0deg,#A3B18A, #EDE6D0 );">
        <div class="card-body p-4">

            <h5 class="text-center mb-3 fw-bold" style="color: #121312;">📩 Enter Verification Code</h5>

            <form method="POST" action="{{ route('password.checkCode') }}">
                @csrf
                <div class="mb-3">
                    <label class="fw-semibold" style="color: #121312;">Code</label>
                    <input type="text" name="code" class="form-control" style="border: 1px solid #BFCFBB; border-radius: 8px; background-color: #fffaf0; color: #344C3D;" required>
                </div>
                <button type="submit" class="btn w-100 fw-bold" style="background-color: #344C3D; color: #BFCFBB; border-radius: 50px;">Verify</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Auto-dismiss success/error alert after 4 seconds
    setTimeout(() => {
        const alert = document.getElementById("success-alert") || document.getElementById("error-alert");
        if (alert) {
            alert.classList.add("fade");
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>
@endsection
