<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Attock GMS</title>

    <!-- Bootstrap + Icons + Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add in your layout (e.g., layouts.adminapp) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




    <style>
        body {
            background-color: #f8f9fa;
            overflow-x: hidden;
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            width: 220px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #ffffff;
            color: #000000;
            padding-top: 60px;
            transition: all 0.3s ease;
            box-shadow: 7px 17px 10px rgba(3, 3, 3, 0.09);
        }
        
        .sidebar.hidden {
            margin-left: -240px;
        }
        
        .sidebar a {
            color: #6c757d;
            text-decoration: none;
            display: block;
            padding: 12px 20px;
            transition: 0.3s ease;
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
            font-weight: 500;
            margin-bottom: 4px;
        }
        
        .sidebar a:hover  {
            background-color: #1aa08a;
            color: #ffffff;
            border-radius: 15px;
            margin-left: 6px;
            margin-right: 6px;
            padding-left: 24px;
        }
        
            .sidebar a:hover i, 
            .sidebar a:hover span,
            .sidebar a.active i,
            .sidebar a.active span
            {
            color: #ffffff;
            }
        
            .sidebar a.hover span{
            color: #ffffff;
            }
        
        .sidebar a.active {
            background-color: #1aa08a;
            color: #ffffff;
            border-radius: 15px;
            margin-left: 6px;
            margin-right: 6px;
            padding-left: 24px;
        }


        /* Navbar */
        .navbar {
            position: fixed;
            top: 0;
            left: 220px;
            right: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: 2px 6px 6px rgba(3, 3, 3, 0.07);
        }

        .navbar.expanded {
            left: 0;
        }

        /* Content */
        .content {
            margin-left: 240px;
            padding: 20px;
            transition: all 0.3s ease;
            margin-top: 70px; /* prevent overlap with navbar */
        }

        .content.expanded {
            margin-left: 0;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                margin-left: -240px;
            }
            .sidebar.active {
                margin-left: 0;
            }
            .navbar {
                left: 0;
            }
            .content {
                margin-left: 0;
            }
        }
    </style>



</head>

<body class="d-flex flex-column min-vh-100">
    @include('layouts.adminnavbar')

    <!-- Main page content -->
    <main class="flex-grow-1">
        @yield('content')
    </main>

    <!-- Optional Footer (minimal for dashboard) -->
    <footer class="text-center text-muted py-3 small bg-light border-top mt-auto">
        © {{ date('Y') }} Attock GMS | Admin Dashboard
    </footer>

    <!-- Sidebar toggle logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebarBtn');
            const content = document.getElementById('mainContent');
            const navbar = document.getElementById('topNavbar');

            toggleBtn.addEventListener('click', () => {
                sidebar.classList.toggle('hidden');
                content.classList.toggle('expanded');
                navbar.classList.toggle('expanded');
            });
        });
    </script>
</body>
</html>