<!-- resources/views/admin/burial_requests/show.blade.php -->
@extends('layouts.app')

@section('content')
<h2>Burial Request Details</h2>
<p>User: {{ $request->user->name }}</p>
<p>Grave: {{ $request->grave->id ?? 'N/A' }}</p>
<p>Status: {{ $request->status }}</p>
<p>Death Certificate: <a href="{{ Storage::url($request->death_certificate) }}" target="_blank">View</a></p>

<form method="POST" action="{{ route('admin.burial.requests.approve', $request->id) }}">
    @csrf
    <button type="submit">Approve Burial</button>
</form>
@endsection
