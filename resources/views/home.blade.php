@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 " style="margin-bottom: 5%; ">

    <!-- 🌿 Hero Section -->
    <section class="hero-section position-relative d-flex align-items-center justify-content-center text-center text-white ">
        <img src="{{ asset('images/main.png') }}" class="img-fluid position-absolute top-0 start-0 w-100 h-100" style="object-fit: cover; z-index:-2;" alt="Graveyard Hero">
        <div class="overlay position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom right, rgba(0,0,0,0.6), rgba(25,135,84,0.2)); z-index:-1;"></div>

        <div class="content px-3">
            <h1 class="display-5 fw-bold mb-3 animate__animated animate__fadeInDown">Attock Graveyard Management System</h1>
            <p class="lead mb-4 animate__animated animate__fadeInUp">Preserving legacy with care, dignity, and digital precision.</p>
            <a href="{{ route('login') }}" class="btn btn-success btn-lg fw-semibold shadow-sm px-4 py-2 animate__animated animate__fadeInUp">Get Started</a>
        </div>
    </section>


    <!-- 🌼 Features Section -->
    <section class="features-section py-5 bg-light ">
        <div class="container">
            <h2 class="text-center fw-bold mb-5 mt-5 ">What You Can Do</h2>
            <div class="row g-4 justify-content-center">

                @php
                $features = [
                    ['icon' => 'fa-search', 'color' => 'text-primary', 'title' => 'Search Burial Records', 'desc' => 'Find detailed records of those buried, including names, dates, and plot locations.', 'btn' => 'Explore Records'],
                    ['icon' => 'fa-cross', 'color' => 'text-secondary', 'title' => 'Grave Reservation', 'desc' => 'Reserve a grave at Attock GMS with verified plot details and documentation.', 'btn' => 'Reserve Now'],
                    ['icon' => 'fa-bus', 'color' => 'text-warning', 'title' => 'Family Transportation', 'desc' => 'Provide transport for family members and relatives attending the funeral.', 'btn' => 'Arrange Transport'],
                    ['icon' => 'fa-th-large', 'color' => 'text-info', 'title' => 'Marble Finishing', 'desc' => 'Add premium marble finishing to graves upon request for a respectful presentation.', 'btn' => 'Customize Grave'],
                    ['icon' => 'fa-headset', 'color' => 'text-danger', 'title' => 'Get Support', 'desc' => 'Need help? Reach out to our team for assistance with records, access, or technical issues.', 'btn' => 'Contact Us'],
                ];
                @endphp

                @foreach($features as $f)
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card text-center p-4 shadow-sm rounded-4 h-100">
                        <div class="icon-container mb-3">
                            <i class="fas {{ $f['icon'] }} fa-2x {{ $f['color'] }}"></i>
                        </div>
                        <h5 class="fw-semibold mb-3">{{ $f['title'] }}</h5>
                        <p class="text-muted">{{ $f['desc'] }}</p>
                        <a href="#" class="btn btn-outline-success rounded-pill px-4 py-1">{{ $f['btn'] }}</a>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>


    <!-- 🌟 Call to Action Section -->
    <section class="cta-section position-relative text-center text-white py-5 mb-4 mt-4  ">
        <img src="{{ asset('images/leave.png') }}" alt="" 
             class="position-absolute top-0 start-0 w-100 h-100" 
             style="object-fit: cover; z-index:-2; filter: brightness(0.6);">
        <div class="overlay position-absolute top-0 start-0 w-100 h-100 " 
             style="background: linear-gradient(to bottom right, rgba(25,135,84,0.7), rgba(0,0,0,0.6)); z-index:-1;"></div>

        <div class="container position-relative">
            <p class="fs-5 fst-italic text-light mt-4 mb-4">
    "كُلُّ نَفْسٍ ذَائِقَةُ الْمَوْتِ" <br>
    <small class="text-light">“Every soul shall taste death.” — Qur’an 3:185</small>
</p>

        </div>
    </section>

</div>


<!-- 🌈 Styles -->
<style>

.hero-section {
    height: 520px;
    position: relative;
}
.hero-section .content {
    max-width: 700px;
}
.feature-card {
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid #e6e6e6;
    transition: all 0.3s ease;
}
.feature-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 25px rgba(25,135,84,0.2);
    background: linear-gradient(180deg, #ffffff 0%, #f0fdf4 100%);
}
.icon-container i {
    transition: transform 0.3s ease;
}
.feature-card:hover i {
    transform: scale(1.2);
}
.cta-section {
    position: relative;
    overflow: hidden;
}
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
