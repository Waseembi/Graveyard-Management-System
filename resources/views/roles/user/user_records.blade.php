@extends('layouts.userapp')

@section('content')

{{-- Success Message --}}
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

<div class="content" id="mainContent">
    <div class="container-fluid">

        <!-- ================= PAGE TITLE ================= -->
        <h4 class="mb-3">My Records</h4>

        <!-- ================= TABS ================= -->
        <ul class="nav nav-tabs" id="recordTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="reg-tab" data-bs-toggle="tab"
                        data-bs-target="#registrations" type="button" role="tab">
                    My Registrations
                </button>
            </li>

            <li class="nav-item" role="presentation">
                <button class="nav-link" id="family-tab" data-bs-toggle="tab"
                        data-bs-target="#family" type="button" role="tab">
                    Family Members
                </button>
            </li>
        </ul>

        <!-- ================= TAB CONTENT ================= -->
        <div class="tab-content mt-3" id="recordTabsContent">

            <!-- ================= REGISTRATIONS TAB ================= -->
            <div class="tab-pane fade show active" id="registrations" role="tabpanel">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        My Registrations
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Status</th>
                                    <th>Burial Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $reg)
                                <tr>
                                    <td>{{ $reg->name }}</td>
                                    <td>{{ $reg->father_name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $reg->status === 'approved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($reg->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $reg->burial_status === 'completed' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($reg->burial_status ?? 'Pending') }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('user.registration.view', $reg->id) }}"
                                           class="btn btn-sm btn-primary">View</a>
                                        
                                        <a href="{{ route('user.registration.edit', $reg->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        No registrations found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ================= FAMILY MEMBERS TAB ================= -->
            <div class="tab-pane fade" id="family" role="tabpanel">

                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white fw-bold">
                        Family Members
                    </div>

                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Relation</th>
                                    {{-- <th>CNIC</th> --}}
                                    <th>Status</th>
                                    <th>Burial Status</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($familyMembers as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->father_name }}</td>
                                    <td>{{ $member->relationship }}</td> 
                                    {{-- <td>
                                        @if($member->cnic)
                                            {{ $member->cnic }}
                                        @else
                                            <span style="color: rgb(156, 155, 155)">NULL</span>
                                        @endif
                                    </td> --}}
                                    <td>
                                        <span class="badge bg-{{ $reg->status === 'approved' ? 'success' : 'warning' }}">
                                            {{ ucfirst($reg->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($member->registration)
                                            <span class="badge bg-{{ $member->registration->burial_status === 'completed' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($member->registration->burial_status ?? 'Pending') }}
                                            </span>
                                        @else
                                            <span class="text-muted">NULL</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('user.family.view', $member->id) }}"
                                           class="btn btn-sm btn-primary">View</a>
                                        
                                        <a href="{{ route('user.family.edit', $member->id) }}"
                                           class="btn btn-sm btn-warning">Edit</a>
                                    </td>


                                     
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">
                                        No family members found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>


{{-- this is use for user_record_family_view and edit  back buttonn , when we click on back button it returns to family registraion table --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Activate tab from URL hash
    const hash = window.location.hash;
    if (hash) {
        const trigger = document.querySelector(
            'button[data-bs-target="' + hash + '"]'
        );

        if (trigger) {
            const tab = new bootstrap.Tab(trigger);
            tab.show();
        }
    }

    // Update URL hash when user clicks tabs
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(btn => {
        btn.addEventListener('shown.bs.tab', function (e) {
            history.replaceState(null, null, e.target.dataset.bsTarget);
        });
    });

});

setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>

@endsection
