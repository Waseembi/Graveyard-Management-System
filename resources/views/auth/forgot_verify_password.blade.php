@extends('layouts.app')
@section('content')
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
@endsection
