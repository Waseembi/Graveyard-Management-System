@extends('layouts.adminapp')

@section('content')
<h2 class="mb-4">Dashboard Overview</h2>

<div class="row g-4 mb-4">
    @foreach([
        ['title' => 'Total Registered Persons', 'value' => $totalRegistrations, 'color' => 'primary'],
        ['title' => 'Total Accounts Created', 'value' => $totalUsers, 'color' => 'success']
    ] as $kpi)
    <div class="col-md-3">
        <div class="card bg-{{ $kpi['color'] }} text-center p-3">
            <h5>{{ $kpi['title'] }}</h5>
            <h3>{{ $kpi['value'] }}</h3>
        </div>
    </div>
    @endforeach
</div>


{{-- <div class="row g-4">
    @foreach([
        ['title' => 'Burial Bookings', 'icon' => 'fa-calendar-check', 'color' => 'primary'],
        ['title' => 'Payments', 'icon' => 'fa-money-bill-wave', 'color' => 'success'],
        ['title' => 'Inventory', 'icon' => 'fa-boxes', 'color' => 'warning text-dark'],
        ['title' => 'Staff Management', 'icon' => 'fa-users', 'color' => 'info'],
    ] as $module)
    <div class="col-md-4">
        <div class="card bg-{{ $module['color'] }} text-white h-100 text-center p-4">
            <i class="fas {{ $module['icon'] }} fa-2x mb-3"></i>
            <h5>{{ $module['title'] }}</h5>
        </div>
    </div>
    @endforeach
</div> --}}


@endsection
