@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="card mx-auto" style="max-width: 400px;">
        <div class="card-body">
            <h5 class="text-center mb-3">🔒 Reset Password</h5>
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <label>New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark w-100">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
