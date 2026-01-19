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
        <h4 class="mb-4 fw-bold text-success">My Records</h4>

        <!-- ================= TABS ================= -->
        <ul class="nav nav-tabs mb-3" id="recordTabs" role="tablist">
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
        <div class="tab-content" id="recordTabsContent">

            <!-- ================= REGISTRATIONS TAB ================= -->
            <div class="tab-pane fade show active" id="registrations" role="tabpanel">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-white fw-semibold d-flex justify-content-between align-items-center" style="background-color: #1d9e7e">
                        <span><i class="fa-solid fa-user me-2"></i> My Registrations</span>
                        <span class="badge bg-light text-success">{{ $registrations->count() }} Records</span>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle table-borderless mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Status</th>
                                    <th>Burial Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($registrations as $index => $reg)
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $reg->name }}</td>
                                    <td>{{ $reg->father_name }}</td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            {{ $reg->status == 'approved' ? 'bg-success' : ($reg->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                            {{ ucfirst($reg->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            {{ $reg->burial_status == 'buried' ? 'bg-black' : 'bg-secondary' }}">
                                            {{ ucfirst($reg->burial_status ?? 'Pending') }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user.registration.view', $reg->id) }}" class="btn btn-sm btn-outline-success rounded-pill me-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.registration.edit', $reg->id) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No registrations found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- ================= FAMILY MEMBERS TAB ================= -->
            <div class="tab-pane fade" id="family" role="tabpanel">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header text-white fw-semibold d-flex justify-content-between align-items-center" style="background-color: #1d9e7e">
                        <span><i class="fa-solid fa-users me-2"></i> Family Members</span>
                        <span class="badge bg-light text-success">{{ $familyMembers->count() }} Records</span>
                    </div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle table-borderless mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Father Name</th>
                                    <th>Relation</th>
                                    <th>Status</th>
                                    <th>Burial Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($familyMembers as $index => $member)
                                <tr>
                                    <td class="fw-semibold text-muted">{{ $index + 1 }}</td>
                                    <td class="fw-bold text-dark">{{ $member->name }}</td>
                                    <td>{{ $member->father_name }}</td>
                                    <td>{{ $member->relationship }}</td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            {{ $member->status == 'approved' ? 'bg-success' : ($member->status == 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                            {{ ucfirst($member->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill 
                                            {{ $member->registration && $member->registration->burial_status == 'buried' ? 'bg-black' : 'bg-secondary' }}">
                                            {{ $member->registration->burial_status ?? 'Pending' }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('user.family.view', $member->id) }}" class="btn btn-sm btn-outline-success rounded-pill me-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('user.family.edit', $member->id) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">No family members found</td>
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

{{-- Tabs & Alert Scripts --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Activate tab from URL hash
    const hash = window.location.hash;
    if (hash) {
        const trigger = document.querySelector('button[data-bs-target="' + hash + '"]');
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

    // Auto-hide success alert
    const alert = document.getElementById('success-alert');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 4000);
    }

});
</script>

@endsection
