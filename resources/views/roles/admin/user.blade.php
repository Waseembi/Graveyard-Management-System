@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- Header -->
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <div>
                <h4 class="fw-bold">👥 Manage Users</h4>
                <p class="text-muted mb-0">View and manage all users in the system.</p>
            </div>
            <form class="d-flex" method="GET" action="{{ route('admin.users') }}">
                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Search user...">
                <button class="btn btn-success btn-sm"><i class="fa-solid fa-search"></i></button>
            </form>
        </div>

        <!-- Stats -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="text-muted mb-0">Active Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <p class="text-muted mb-0">Blocked Users</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h6 class="mb-0 fw-semibold">User List</h6>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $index => $user)
                        <tr>
                            <td>{{ $index + $registrations->firstItem() }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-primary">{{ ucfirst($user->role->role_name ?? 'User') }}</span></td>
                            <td>
                                <span class="badge bg-{{ $user->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($user->status ?? 'inactive') }}
                                </span>
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning"><i class="fa-solid fa-pen"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
