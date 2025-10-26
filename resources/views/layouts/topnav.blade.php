<nav class=" bg-light border-end navbar navbar-expand-lg px-4" >
    <div class="container-fluid">
        <!-- Branding (optional) -->
        <a class="navbar-brand text-white fw-semibold " href="#" style="margin-left: 220px">Attock GMS</a>

        <!-- Right-side nav items -->
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="fas fa-bell me-1"></i> Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#"><i class="fas fa-user me-1"></i> Profile</a>
                </li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light ms-2">Logout</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>



{{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4">
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="#">Notifications</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Profile</a></li>
            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-sm btn-outline-light">Logout</button>
                </form>
            </li>
        </ul>
    </div>
</nav>


 --}}
