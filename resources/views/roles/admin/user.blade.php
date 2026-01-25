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

     

<!-- Unified Green Stat Overview -->
<div class="card shadow-sm border-0 text-white mb-4" style="background: linear-gradient(180deg,#1d9e7e, rgb(26, 158, 136));  border-radius: 10px; " >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="fa-solid fa-users fs-4 me-2 ms-4 mt-1"  style="background-color: rgba(109, 235, 214, 0.3); padding-top: 5%; padding-bottom: 5%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Total Registrations</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $stats['total'] }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="fa-solid fa-user-check fs-4 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 5%; padding-bottom: 5%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Approved Users</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $stats['approved'] }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="fa-solid fa-hourglass-half fs-4 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 5%; padding-bottom: 5%; padding-left: 6%; padding-right: 6%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Pending Users</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $stats['pending'] }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 d-flex align-items-center">
                <i class="fa-solid fa-user-slash fs-4 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 5%; padding-bottom: 5%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1 ">Buried Users</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $stats['buried'] }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>


       <!-- User Table -->
<div class="card shadow-lg border-0 rounded-4 mt-5">
    <div class="card-header  text-white fw-semibold d-flex justify-content-between align-items-center" style="background-color: #1d9e7e">
        <span><i class="fa-solid fa-users me-2"></i> User List</span>
        <span class="badge bg-light text-success">{{ $registrations->total() }} Users</span>
    </div>

    <div class="card-body table-responsive">
        <table class="table table-hover align-middle table-borderless">
            <thead class="table-success">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Father Name</th>
                    <th>Status</th>
                    <th>Burial Status</th>
                    <th>Joined</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($registrations as $index => $user)
                    <tr>
                        <td class="fw-semibold text-muted">{{ $index + $registrations->firstItem() }}</td>
                        <td class="fw-bold text-dark">{{ $user->name }}</td>
                        <td>{{ $user->father_name }}</td>

                        <td>
                            <span class="badge rounded-pill 
                                {{ $user->status == 'approved' ? 'bg-success' : ($user->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ ucfirst($user->status) }}
                            </span>
                        </td>

                        <td>
                            <span class="badge rounded-pill 
                                {{ $user->burial_status == 'buried' ? 'bg-dark' : 'bg-secondary' }}">
                                {{ ucfirst($user->burial_status) }}
                            </span>
                        </td>

                        <td class="text-muted">{{ $user->created_at->format('d M Y') }}</td>

                        <td class="text-center">
                            <a href="{{ route('admin.users.show', $user->id) }}" 
                               class="btn btn-sm btn-outline-success rounded-pill me-1">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" 
                               class="btn btn-sm btn-outline-warning rounded-pill me-1">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                  method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger rounded-pill delete-user">
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
            {{ $registrations->links('pagination::bootstrap-5') }}
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


    /* Card header */
    .card-header.bg-gradient-dark {
        background: linear-gradient(135deg, #444, #222);
        border-radius: 12px 12px 0 0;
        font-size: 1rem;
    }

    /* Table row hover effect */
    /* .table-hover tbody tr:hover {
        background-color: rgba(0, 0, 0, 0.03);
        transform: translateY(-2px);
        transition: 0.2s ease;
    } */

    /* Badge styling */
    .badge {
        font-size: 0.85rem;
        padding: 0.35rem 0.65rem;
        font-weight: 500;
    }

    /* Action buttons */
    .btn-info, .btn-warning, .btn-danger {
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .btn-info:hover {
        background-color: #3bb3ff;
    }

    .btn-warning:hover {
        background-color: #ffb84d;
    }

    .btn-danger:hover {
        background-color: #d33;
    }

</style>

@endsection
