@extends('layouts.adminapp')

@section('content')
<div class="content" id="mainContent">
    <div class="container-fluid">


        <!-- Welcome -->
        <div class="mb-4">
            <h4>Welcome, {{ Auth::user()->name ?? 'User' }} 👋</h4>
        </div>


<!-- Unified Green Stat Overview -->
<div class="card shadow-sm border-0 text-white mb-4" style="background: linear-gradient(180deg,#1d9e7e, rgb(26, 158, 136));  border-radius: 10px; padding:1%;" >
    <div class="card-body" >
        <div class="row" >
            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="bi bi-people-fill fs-3 me-2 ms-4 mt-1"  style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Total Users</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $totalUsers }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="bi bi-file-earmark-text-fill fs-3 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Total Registrations</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $totalRegistrations }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 border-end border-white d-flex align-items-center">
                <i class="bi bi-tree-fill fs-3 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1">Total Buried</h6>
                    <h3 class="fw-bold mb-0 text-center">{{ $totalBurials }}</h3>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 d-flex align-items-center">
                <i class="bi bi-wallet2 fs-3 me-2 ms-4 mt-1" style="background-color: rgba(109, 235, 214, 0.3); padding-top: 2%; padding-bottom: 2%; padding-left: 5%; padding-right: 5%; border-radius: 60%;"></i>
                <div class="mt-3 mb-3">
                    <h6 class="mb-1 ">Payments</h6>
                    <h3 class="fw-bold mb-0 text-center">0</h3>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Charts Section -->
<div class="row g-4 mb-4 mt-3">
    
    <!-- Registrations Per Year -->
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <i class="bi bi-bar-chart-line-fill text-success me-2 fs-5"></i>
                Registrations Per Year
            </div>
            <div class="dashboard-body">
                <canvas id="registrationsChart" height="170"></canvas>
            </div>
        </div>
    </div>

    <!-- Burials Per Year -->
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <i class="bi bi-graph-up-arrow text-primary me-2 fs-5"></i>
                Burials Per Year
            </div>
            <div class="dashboard-body">
                <canvas id="burialsChart" height="170"></canvas>
            </div>
        </div>
    </div>

    <!-- Registration Status -->
    <div class="col-md-4">
        <div class="dashboard-card">
            <div class="dashboard-header">
                <i class="bi bi-pie-chart-fill text-warning me-2 fs-5"></i>
                Registration Status
            </div>
            <div class="dashboard-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>

</div>



        <!-- Recent Registrations -->
<div class="card shadow-sm border-0 mt-4">
    <div class="card-header bg-white">
        <h6 class="mb-0">Recent Registrations</h6>
    </div>
    <div class="card-body">
        <table class="table table-hover mb-0">
            <thead>
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
                @foreach($recentRegistrations as $index => $reg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $reg->name }}</td>
                    <td>{{ $reg->father_name }}</td>
                    <td>{{ $reg->cnic ?? 'N/A' }}</td>
                    <td>{{ $reg->age }}</td>
                    <td>
                        <span class="badge bg-{{ $reg->status == 'approved' ? 'success' : ($reg->status == 'pending' ? 'warning text-dark' : 'danger') }}">
                            {{ ucfirst($reg->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
        <div class="mt-3">
            {{ $recentRegistrations->links('pagination::bootstrap-5') }}
        </div>

</div>



    </div>
</div>









<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const years = @json($years);
    const registrationsData = @json($registrationsData);
    const burialsData = @json($burialsData);
    const statusData = @json(array_values($statusCounts));
    const statusLabels = @json(array_keys($statusCounts));

    // Create gradient for charts
    function createGradient(ctx, color) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, color + "B3"); 
        gradient.addColorStop(1, color + "1A"); 
        return gradient;
    }

    // Registrations Chart
    const regCtx = document.getElementById('registrationsChart').getContext('2d');
    new Chart(regCtx, {
        type: 'bar',
        data: {
            labels: years,
            datasets: [{
                label: 'Registrations',
                data: registrationsData,
                backgroundColor: createGradient(regCtx, "#4caf50")
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } },
            animation: { duration: 900 }
        }
    });

    // Burials Chart
    const burCtx = document.getElementById('burialsChart').getContext('2d');
    new Chart(burCtx, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Burials',
                data: burialsData,
                borderColor: "#1d9e7e",
                backgroundColor: createGradient(burCtx, "#1d9e7e"),
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } },
            animation: { duration: 900 }
        }
    });

    // Doughnut Chart
    new Chart(document.getElementById('statusChart'), {
        type: 'doughnut',
        data: {
            labels: statusLabels,
            datasets: [{
                data: statusData,
                backgroundColor: ['#1d9e7e', '#ffb74d', '#e57373']
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 18 }
                }
            },
            cutout: '65%'
        }
    });
</script>






<style>
    .dashboard-card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0,0,0,0.08);
        transition: transform .2s ease, box-shadow .2s ease;
        background: #fff;
    }

    .dashboard-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 26px rgba(0,0,0,0.15);
    }

    .dashboard-header {
        background: #ffffff;
        padding: 14px 18px;
        font-weight: 600;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        font-size: 15px;
    }

    .dashboard-body {
        padding: 20px;
        background: linear-gradient(to bottom, #f8f9fa, #eef2f5);
    }

    canvas {
        padding-top: 10px;
    }
</style>


@endsection
