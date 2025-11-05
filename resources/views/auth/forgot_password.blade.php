@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="text-center mb-3">🔐 Forgot Password</h5>

            @if(session('success'))
                <div class="alert alert-success text-center">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('password.sendCode') }}">
                @csrf
                <div class="mb-3">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Verification Code</button>
            </form>
        </div>
    </div>
</div>
@endsection
