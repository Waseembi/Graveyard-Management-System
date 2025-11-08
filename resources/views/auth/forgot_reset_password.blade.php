@extends('layouts.app')
@section('content')
<div class="container py-5">
    <div class="card mx-auto shadow-lg rounded-4" style="max-width: 400px; border: none; background: linear-gradient(0deg,#A3B18A, #EDE6D0 );">
        <div class="card-body p-4">
            <h5 class="text-center mb-4 fw-bold" style="color: #1b1b1b;">🔒 Reset Password</h5>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <div class="mb-3">
                    <label class="fw-semibold" style="color: #141414;">New Password</label>
                    <input type="password" name="password" class="form-control" style="border: 1px solid #BFCFBB; border-radius: 8px; background-color: #fffaf0; color: #344C3D;" required>
                </div>
                <div class="mb-3">
                    <label class="fw-semibold" style="color: #121312;">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" style="border: 1px solid #BFCFBB; border-radius: 8px; background-color: #fffaf0; color: #344C3D;" required>
                </div>
                <button type="submit" class="btn w-100 fw-bold" style="background-color: #344C3D; color: #BFCFBB; border-radius: 50px;">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
