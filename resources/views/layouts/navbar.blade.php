

<nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background: linear-gradient(270deg,#6abd9a, #2f2f2f);">

    <div class="container justify-content-center">
        <!-- Circular Logo -->
            <div class="text-center ">
                <img src="{{ asset('images/logogms-removebg.png') }}" 
                     alt="GMS Logo" 
                     class="img-fluid ms-2 "
                     style="width: 68px; height: 68px; border-radius: 40%;  object-fit: cover; ">
            </div>
            {{-- 🪦 --}}
        <a class="navbar-brand text-white fw-bold  ms-1 " href="{{ route('home') }}" style="margin-right: 6%">  Attock GMS</a>
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
                {{-- <li class="nav-item me-3">
                    <a class="nav-link text-white" href="#">
                        <i class="fa-solid fa-bell"></i>
                    </a>
                </li> --}}

                <li class="nav-item dropdown">


               <a class="nav-link dropdown-toggle d-flex align-items-center  me-0" href="#" id="profileDropdown"       role="button"   data-bs-toggle="dropdown" aria-expanded="false">
                   @if(Auth::user()->profile_image)
                       <img src="{{ asset('profile_images/user/' . Auth::user()->profile_image) }}" 
                            alt="Profile Image" 
                            class="rounded-circle me-3" 
                            style="width: 35px; height: 35px; object-fit: cover;">
                   @else
                       <i class="fa-solid fa-user me-3"></i>
                   @endif
                   {{ Auth::user()->name ?? 'User' }}
                   <i class="fa-solid fa-caret-down ms-1 "></i>
               </a>



    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3" aria-labelledby="profileDropdown">
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.dashboard') }}">
                <i class="fa-solid fa-gauge me-2 text-primary"></i> Dashboard
            </a>
        </li>
        <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('user.profile') }}">
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

.navbar {
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.2);
    height: 40px;          /* fix the navbar height */
    min-height: 58px;      /* ensure it doesn’t shrink */
}


/* Base navbar link style */
.navbar-nav .nav-link {
    color: #f8f9fa !important;
    font-weight: 500;
    transition: all 0.3s ease;
    font-size: 102%;
}

/* Hover effect: emerald green */
.navbar-nav .nav-link:hover,
.navbar-nav .nav-link:focus {
    color: #27c985 !important;
    transform: translateY(-1px);
}

/* Active link styling */
.active-link {
    color: #27c985 !important;
    font-weight: bold;
    border-bottom: 2px solid #27c985;
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
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
    border-radius: 0.5rem;
    background-color: #ffffff;
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
    background-color: #e9f7ef !important;
    color: #000 !important;
}

/* Optional: Logo border glow */
.navbar-brand img {
    border: 2px solid #27c985 !important;
    box-shadow: 0 0 6px rgba(39, 201, 133, 0.4);
}




</style>