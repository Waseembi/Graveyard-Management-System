@extends('layouts.adminapp')

@section('content')

{{-- success message --}}
        @if(session('success'))
            <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 400px;
                z-index: 1050;
                box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
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
            <div id="success-alert" class="alert alert-danger text-center mx-auto mt-5" style="
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 400px;
                z-index: 1050;
                box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
                line-height: 1.3;
            ">      
                 {{ session('error') }}
        </div>
        @endif

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
                            <th>Father Name</th>
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
                            <td>{{ $user->father_name }}</td>

                            <td>
                                <span class="badge bg-{{ $user->status == 'approved' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($user->status ?? 'inactive') }}
                                </span>
                            </td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>

                            <td>
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger delete-user">
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



<script>
$(function () {
    
    // SweetAlert2 delete confirmation
    $(".delete-user").on('click', function (e) {
        e.preventDefault();
        const form = $(this).closest('form');

        Swal.fire({
            title: "Are you sure?",
            text: "This record will be permanently deleted!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "Cancel",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});

// Auto-dismiss success alert after 4 seconds
setTimeout(() => {
    const alert = document.getElementById("success-alert");
    if (alert) {
        alert.classList.add("fade");
        setTimeout(() => alert.remove(), 500);
    }
}, 4000);
</script>




@endsection
