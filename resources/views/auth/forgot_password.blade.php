@extends('layouts.app')
@section('content')
    {{-- error message --}}
    @if($errors->any())
        <div id="error-alert" 
         class="alert alert-danger text-center mx-auto position-fixed top-0 start-50 translate-middle-x py-1" 
            style="max-width: 400px; z-index: 1050; margin-top: 6%; font-size: 0.9rem; line-height: 1.7;">
            {{ $errors->first() }}
        </div>
    @endif

<div class="container py-5">
    <div class="card mx-auto shadow-lg rounded-4" style="max-width: 400px; border: none; background: linear-gradient(0deg,#A3B18A, #EDE6D0 );">
        <div class="card-body p-4">

            <!-- Header -->
            <h5 class="text-center mb-3 fw-bold" style="color: #344C3D;">🔐 Forgot Password</h5>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert text-center" style="background-color: #344C3D; color: #BFCFBB; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert text-center" style="background-color: #D9CBB7; color: #344C3D; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('password.sendCode') }}">
                @csrf
                <div class="mb-3">
                    <label class="fw-semibold" style="color: #344C3D;">Email Address</label>
                    <input type="email" name="email" class="form-control" style="border: 1px solid #344C3D; border-radius: 8px; background-color: #fffaf0; color: #344C3D;" required>
                </div>
                <button type="submit" class="btn w-100 fw-bold" style="background-color: #344C3D; color: #BFCFBB; border-radius: 50px;">Send Verification Code</button>
            </form>
        </div>
    </div>
</div>
@endsection
