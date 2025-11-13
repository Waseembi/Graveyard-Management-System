<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="text-center mb-4">
        <img src="{{ asset('images/logogms-removebg.png') }}" alt="Attock GMS Logo" class=""
                 style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; margin-bottom: -7%; margin-top: -12%;">
        {{-- <h5>⚰️ Attock GMS</h5> --}}
    </div>

    <a href="{{ route('user.dashboard') }}" class="{{ request()->routeIs('user.dashboard') ? 'active' : '' }}" style="color: black;">
        <i class="bi bi-house-door me-2" ></i><span>Dashboard</span>
    </a>

    <a href="{{ route('user.register.create') }}" class="{{ request()->routeIs('user.register.create') ? 'active' : '' }}" style="color: black;"><i class="bi bi-journals me-2"></i><span>Register</span></a>

    <a href="{{ route('family.create') }}" class="{{ request()->routeIs('family.create') ? 'active' : '' }}" style="color: black;"><i class="bi bi-people me-2"></i><span>Register For Family</span></a>

    <a href="#" style="color: black;"><i class="bi bi-receipt me-2"  ></i><span>Payments</span></a>

    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}" style="color: black;"><i class="bi bi-person-gear me-2"></i><span>Profile</span></a>
    

    <!-- 🌐 Back to Website -->
    <a href="{{ route('home') }}">
        <i class="fa-solid fa-globe me-2 mt-3 text-info"  ></i> <span style="color: black;">Back to Website</span>
    </a>

    <form method="POST" action="{{ route('logout') }}" class="mt-3 px-3">
        @csrf
        <button class="btn btn-danger w-100">
            <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
        </button>
    </form>
</div>

<!-- Top Navbar -->
<nav class="navbar navbar-expand-lg  shadow-sm px-3" id="topNavbar" style="background-color: #ffffff; ">
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
