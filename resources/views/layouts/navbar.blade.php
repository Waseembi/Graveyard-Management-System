<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container justify-content-center">
        <a class="navbar-brand fw-bold me-5" href="{{ route('home') }}">🪦 Attock GMS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-center " id="navbarContent" >
            <ul class="navbar-nav text-center">
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active-link' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active-link' : '' }}" href="{{ route('about') }}">About</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('search') ? 'active-link' : '' }}" 
                        href="{{ route('search') }}">Search</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('GraveReservation') ? 'active-link' : '' }}" href="{{ route('registration.create') }}">GraveReservation</a>
                </li>
                <li class="nav-item mx-3">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active-link' : '' }}" href="{{ route('contact') }}">Contact</a>
                </li>
                
            </ul>


            {{-- //authication links --}}
            <ul class="navbar-nav ms-auto">
            @auth
        <li class="nav-item me-3">
            <a class="nav-link text-white" href="#">
                <i class="fa-solid fa-bell"></i>
            </a>
        </li>

        <li class="nav-item dropdown">


    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa-solid fa-user me-2"></i> {{ Auth::user()->name ?? 'User' }}
    <i class="fa-solid fa-caret-down ms-2"></i>
</a>



    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" aria-labelledby="profileDropdown">
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.dashboard') }}">
                <i class="fa-solid fa-gauge me-2 text-primary"></i> Dashboard
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="fa-solid fa-user-gear me-2 text-secondary"></i> Profile
            </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="dropdown-item text-danger d-flex align-items-center">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</li>

    @else
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
        </li>
    @endauth
</ul>
















            {{-- <ul class="navbar-nav ms-auto">
                @auth
                    <li class="nav-item">
                        <span class="navbar-text text-white fw-semibold ms-1 me-2" style="margin-top: 1px; display:                  inline-block;">
                            Hi, {{ Auth::user()->name }}
                        </span>
                    </li>

                     <li class="nav-item">
        <a class="btn btn-warning ms-3" href="{{ route('user.dashboard') }}">
            <i class="fa-solid fa-gauge"></i> Dashboard
        </a>
    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-outline-light ms-3">Logout</button>
                        </form>
                    </li>
                    
                @else
                    <li class="nav-item " >
                        <a class="nav-link " href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul> --}}





        </div>
    </div>
</nav>





<style>

/* Base navbar link style */
.navbar-nav .nav-link {
    color: #fff !important;
    font-weight: 500;
    transition: color 0.3s ease;
}

/* Hover effect: yellow text */
.navbar-nav .nav-link:hover,
.navbar-nav .nav-link:focus {
    color: #ffc107 !important;
    text-decoration: none;
}

/* Active link styling */
.active-link {
    color: #ffc107 !important;
    font-weight: bold;
}

/* Remove underline animation */
.navbar-nav .nav-link::after {
    display: none !important;
}

/* Dropdown toggle arrow */
.dropdown-toggle::after {
    display: none !important;
}

/* Dropdown menu styling */
.dropdown-menu {
    border: none;
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    border-radius: 0.5rem;
}

/* Dropdown items */
.dropdown-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    color: #212529;
    transition: background-color 0.2s ease;
}

/* Dropdown hover effect */
.dropdown-item:hover {
    background-color: #f8f9fa !important;
    color: #000 !important;
}



</style>
