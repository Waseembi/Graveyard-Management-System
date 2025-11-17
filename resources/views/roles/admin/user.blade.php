@extends('layouts.adminapp')

@section('content')

{{-- Success Alert --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
    ">      
        {{ session('success') }}
    </div>
@endif

{{-- Error Alert --}}
@if(session('error'))
    <div id="error-alert" class="alert alert-error text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
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
                <p class="text-muted mb-0">View and manage all registered users.</p>
            </div>
            <form class="d-flex" method="GET" action="{{ route('admin.users') }}">
                <input type="text" name="search" class="form-control form-control-sm me-2"
                       placeholder="Search user...">
                <button class="btn btn-success btn-sm">
                    <i class="fa-solid fa-search"></i>
                </button>
            </form>
        </div>

      
        <!-- Stats Section -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card bg-gradient-success d-flex align-items-center">
            <div class="stat-icon me-3">
                <i class="fa-solid fa-users fa-1x"></i>
            </div>
            <div>
                <div class="stat-title">Total Users</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-gradient-info d-flex align-items-center">
            <div class="stat-icon me-3">
                <i class="fa-solid fa-user-check fa-1x"></i>
            </div>
            <div>
                <div class="stat-title">Approved Users</div>
                <div class="stat-value">{{ $stats['approved'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-gradient-warning d-flex align-items-center">
            <div class="stat-icon me-3">
                <i class="fa-solid fa-hourglass-half fa-1x"></i>
            </div>
            <div>
                <div class="stat-title">Pending Users</div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-gradient-dark d-flex align-items-center">
            <div class="stat-icon me-3">
                <i class="fa-solid fa-user-slash fa-1x"></i>
            </div>
            <div>
                <div class="stat-title">Buried Users</div>
                <div class="stat-value">{{ $stats['buried'] }}</div>
            </div>
        </div>
    </div>
</div>


        <!-- User Table -->
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white fw-semibold">
                User List
            </div>
            <div class="card-body table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Father Name</th>
                        <th>Status</th>
                        <th>Burial Status</th>
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
                                <span class="badge bg-{{ $user->status == 'approved' ? 'success' : ($user->status == 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </td>

                            <td>
                                <span class="badge {{ $user->burial_status == 'buried' ? 'bg-dark' : 'bg-secondary' }}">
                                    {{ ucfirst($user->burial_status) }}
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

                                <form action="{{ route('admin.users.destroy', $user->id) }}"
                                      method="POST" class="d-inline delete-form">
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

<!-- SweetAlert Delete Confirmation -->
<script>
$(function () {
    $(".delete-user").on("click", function () {
        const form = $(this).closest("form");

        Swal.fire({
            title: "Are you sure?",
            text: "This user will be deleted permanently!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Delete",
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});

// Auto-remove alerts
setTimeout(function() {
        const alert = document.getElementById('success-alert', 'error-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>



<style>
  .stat-card {
    border-radius: 16px;
    padding: 20px;
    color: #fff;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transition: 0.25s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    .stat-icon {
        font-size: 32px;
        opacity: 0.85;
    }

    .stat-title {
        font-size: 14px;
        opacity: 0.9;
        margin-bottom: 4px;
    }

    .stat-value {
        font-size: 26px;
        font-weight: 700;
    }

    /* Gradients */
    .bg-gradient-success { background: linear-gradient(135deg, #34c759, #1e8e3e); }
    .bg-gradient-info    { background: linear-gradient(135deg, #4c8bf5, #2962ff); }
    .bg-gradient-warning { background: linear-gradient(135deg, #ffb300, #ff8f00); }
    .bg-gradient-dark    { background: linear-gradient(135deg, #444, #222); }

</style>

@endsection
