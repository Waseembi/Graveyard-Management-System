@extends('layouts.userapp')

@section('content')
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
                                    <th>CNIC</th>
                                    <th>Status</th>
                                    <th>Burial Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($familyMembers as $member)
                                <tr>
                                    <td>{{ $member->name }}</td>
                                    <td>{{ $member->father_name }}</td>
                                    <td>{{ $member->relationship }}</td> 
                                    <td>
                                        @if($member->cnic)
                                            {{ $member->cnic }}
                                        @else
                                            <span style="color: rgb(156, 155, 155)">NULL</span>
                                        @endif
                                    </td>
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
@endsection
