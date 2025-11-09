<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attock GMS</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logogms-removebg.png') }}">


<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Your custom CSS -->
{{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    {{-- this is for contact page --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}


</head>
<body class="d-flex flex-column min-vh-100">
    @include('layouts.navbar')
    <main class="flex-grow-1">
        @yield('content')
    </main>
    @include('layouts.footer')

    <!-- ✅ Only ONE Bootstrap JS (5.3.3) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>




</html>
