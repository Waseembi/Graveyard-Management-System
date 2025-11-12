@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid py-3">

        <!-- Dashboard Header -->
        <div class="mb-4">
            <h4 class="fw-semibold text-dark">Dashboard</h4>
            <p class="text-muted mb-0">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</p>
        </div>

        <!-- Top Stats Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card text-center shadow-sm border-0" style="background-color:#1ebba1; color:white;">
                    <div class="card-body p-3">
                        <i class="bi bi-people fs-3 mb-1"></i>
                        <h5 class="mb-0">{{ $totalUsers }}</h5>
                        <small>Total Users</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center shadow-sm border-0" style="background-color:#43a047; color:white;">
                    <div class="card-body p-3">
                        <i class="bi bi-file-earmark-text fs-3 mb-1"></i>
                        <h5 class="mb-0">{{ $totalRegistrations }}</h5>
                        <small>Registrations</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center shadow-sm border-0" style="background-color:#2e7d32; color:white;">
                    <div class="card-body p-3">
                        <i class="bi bi-tree-fill fs-3 mb-1"></i>
                        <h5 class="mb-0">{{ $totalBurials }}</h5>
                        <small>Total Burials</small>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card text-center shadow-sm border-0" style="background-color:#66bb6a; color:white;">
                    <div class="card-body p-3">
                        <i class="bi bi-wallet2 fs-3 mb-1"></i>
                        <h5 class="mb-0">0</h5>
                        <small>Payments</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 fw-semibold">Email Sent</div>
                    <div class="card-body">
                        <canvas id="emailChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 fw-semibold">Revenue</div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="150"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 fw-semibold">Monthly Earnings</div>
                    <div class="card-body">
                        <canvas id="earningsChart" height="150"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Registrations Table -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">Recent Registrations</div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>CNIC</th>
                            <th>Age</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentRegistrations as $index => $reg)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $reg->name }}</td>
                            <td>{{ $reg->father_name }}</td>
                            <td>{{ $reg->cnic ?? 'N/A' }}</td>
                            <td>{{ $reg->age }}</td>
                            <td>
                                <span class="badge bg-{{ 
                                    $reg->status == 'approved' ? 'success' : 
                                    ($reg->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                                    {{ ucfirst($reg->status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No recent registrations found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Email Sent Chart (Line)
    new Chart(document.getElementById('emailChart'), {
        type: 'line',
        data: {
            labels: ['2010','2012','2014','2016','2018','2020'],
            datasets: [{
                label: 'Emails',
                data: [30, 40, 60, 45, 80, 90],
                backgroundColor: 'rgba(30,187,161,0.2)',
                borderColor: '#1ebba1',
                fill: true,
                tension: 0.4
            }]
        },
        options: { plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
    });

    // Revenue Chart (Bar)
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: {
            labels: ['2010','2012','2014','2016','2018','2020'],
            datasets: [{
                label: 'Revenue',
                data: [20, 30, 50, 40, 70, 90],
                backgroundColor: '#43a047'
            }]
        },
        options: { plugins:{legend:{display:false}}, scales:{y:{beginAtZero:true}} }
    });

    // Monthly Earnings (Doughnut)
    new Chart(document.getElementById('earningsChart'), {
        type: 'doughnut',
        data: {
            labels: ['Marketplace','Last Week','Last Month'],
            datasets: [{
                data: [3654, 954, 8462],
                backgroundColor: ['#1ebba1','#81C784','#C8E6C9']
            }]
        },
        options: { plugins:{legend:{display:false}} }
    });
</script>
@endsection
