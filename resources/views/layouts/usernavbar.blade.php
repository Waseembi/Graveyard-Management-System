<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="text-center mb-4">
        <h5>⚰️ Attock GMS</h5>
    </div>
    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
        <i class="fa-solid fa-house me-2"></i>Dashboard
    </a>
    <a href="{{ route('user.register.create') }}"><i class="fa-solid fa-book me-2"></i>Register</a>
    <a href="{{ route('family.create') }}"><i class="bi bi-people me-2"></i>Register For Family</a>
    <a href="#"><i class="fa-solid fa-receipt me-2"></i>Payments</a>
    <a href="#"><i class="fa-solid fa-user-gear me-2"></i>Profile</a>

    <!-- 🌐 Back to Website -->
    <a href="{{ route('home') }}">
        <i class="fa-solid fa-globe me-2 text-info"></i> Back to Website
    </a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">
            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
        </button>
    </form>
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm px-3" id="topNavbar">
    <div class="container-fluid">
        <!-- Toggle Button -->
        <button class="btn btn-outline-secondary me-3" id="toggleSidebarBtn">
            <i class="fa-solid fa-bars"></i>
        </button>

        <h5 class="mb-0">User Dashboard</h5>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item me-3">
                <a class="nav-link" href="#"><i class="fa-solid fa-bell"></i></a>
            </li>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown">
            <i class="fa-solid fa-user me-2"></i> {{ Auth::user()->name ?? 'User' }}
            </a>


                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
