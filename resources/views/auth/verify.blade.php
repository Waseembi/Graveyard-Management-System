@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="text-center mb-3">📧 Email Verification</h5>

            @if(session('email'))
                <p class="text-muted text-center">We’ve sent a code to <strong>{{ session('email') }}</strong></p>
            @endif

            @if($errors->any())
                <div class="alert alert-danger text-center">{{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('verify.code') }}">
    @csrf
    <input type="hidden" name="email" value="{{ old('email', session('email')) }}">
    
    <div class="mb-3">
        <label>Verification Code</label>
        <input type="text" name="code" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success w-100">Verify & Create Account</button>
</form>

        </div>
    </div>
</div>
@endsection
