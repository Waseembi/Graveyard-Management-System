@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent" style="padding-top: 5px;"> 
    <div class="container-fluid py-4">
        <div class="row">

            <!-- Main content column -->
            <div class="col-md-12">
                <h4 class="mb-4">Marble Service Requests</h4>

                @if($bookings->isEmpty())
                    <div class="alert alert-info">
                        No marble service requests found.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>DOB</th>
                                    <th>Age</th>
                                    <th>Date of Death</th>
                                    <th>Grave ID</th>
                                    <th>Payment</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $key => $booking)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $booking->user->name ?? 'Unknown User' }}</td>
                                        <td>{{ $booking->burial->name ?? 'N/A' }}</td>
                                        <td>{{ $booking->burial->father_name ?? 'N/A' }}</td>
                                        <td>{{ $booking->registration->dob ?? 'N/A' }}</td>
                                        <td>{{ $booking->registration->age ?? 'N/A' }}</td>
                                        <td>{{ $booking->burial->date_of_death ?? 'N/A' }}</td>
                                        <td>{{ $booking->grave_id }}</td>
                                        <td>{{ ucfirst($booking->payment_method) }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($booking->status === 'pending') bg-secondary
                                                @elseif($booking->status === 'approved') bg-success
                                                @elseif($booking->status === 'inprocess') bg-warning
                                                @elseif($booking->status === 'completed') bg-primary
                                                @elseif($booking->status === 'rejected') bg-danger
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($booking->status === 'pending')
                                                <form action="{{ route('admin.marble.update', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button class="btn btn-success btn-sm">Approve</button>
                                                </form>
                                                <form action="{{ route('admin.marble.update', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button class="btn btn-danger btn-sm">Reject</button>
                                                </form>
                                            @elseif($booking->status === 'approved')
                                                <form action="{{ route('admin.marble.update', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="inprocess">
                                                    <button class="btn btn-warning btn-sm">Mark In Process</button>
                                                </form>
                                            @elseif($booking->status === 'inprocess')
                                                <form action="{{ route('admin.marble.update', $booking->id) }}" method="POST" class="d-inline">
                                                    @csrf @method('PATCH')
                                                    <input type="hidden" name="status" value="completed">
                                                    <button class="btn btn-primary btn-sm">Mark Completed</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
