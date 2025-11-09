@extends('layouts.app')

@section('content')
<div class="about-wrapper" >

    <!-- 🌿 Hero Section -->
    <section class="py-5 bg-gradient " >
        <div class="container">
            <div class="row align-items-center g-5 flex-column-reverse flex-lg-row" style="margin-top: -2%;">

                <!-- Text Content -->
                <div class="col-lg-7">
                    <h2 class="fw-bold  mb-4">Attock Graveyard Management System</h2>
                    <p class="text-muted fs-5 mb-3">
                        Built with a mission to bring <strong>dignity, clarity, and ease</strong> to graveyard record management. We blend thoughtful design with reliable technology to help communities preserve legacy and honor those who came before.
                    </p>
                    <ul class="list-unstyled mb-4">
                        @foreach([
                            'Search and access burial records easily.',
                            'Manage graveyard plot availability and reservations.',
                            'Provide family support and transportation arrangements.',
                            'Ensure accurate record-keeping and reporting.'
                        ] as $item)
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2 icon-bounce"></i>{{ $item }}
                        </li>
                        @endforeach
                    </ul>
                    <p class="text-muted fs-6">
                        Because every life deserves to be remembered — and every record deserves to be accurate.
                    </p>
                </div>

                <!-- Image -->
                <div class="col-lg-5 text-center">
                    <div class="image-frame position-relative d-inline-block">
                        <img src="{{ asset('websiteimages/loginlogo.jpeg') }}" alt="Graveyard Image"
                             class="rounded-4 shadow-lg border border-secondary hero-image">
                        <div class="corner-dot top-left"></div>
                        <div class="corner-dot bottom-right"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 🌟 Vision & Mission -->
    <section class="py-5">
        <div class="container text-center">
            <h3 class="fw-bold  mb-5">Our Vision & Mission</h3>
            <div class="row g-4">
                @foreach([
                    ['title' => 'Our Vision', 'text' => 'To create a digital graveyard management system that honors every individual and simplifies administrative processes for communities.'],
                    ['title' => 'Our Mission', 'text' => 'To provide accurate, respectful, and efficient management of graveyard records while ensuring transparency, support, and dignity for families.']
                ] as $card)
                <div class="col-md-6">
                    <div class="card-box h-100 p-4 bg-white shadow-sm rounded-4 border-start border-5 border-success">
                        <h5 class="fw-semibold mb-3">{{ $card['title'] }}</h5>
                        <p class="text-muted mb-0">{{ $card['text'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 🌈 Why Choose Us -->
<section class="py-5">
    <div class="container text-center">
        <h3 class="fw-bold  mb-5">Why Choose Attock GMS?</h3>
        <div class="row g-4">
            @foreach([
                ['icon' => 'fa-lock', 'title' => 'Secure Records', 'desc' => 'All burial records are safely stored and protected digitally.', 'color' => '#e74c3c'],
                ['icon' => 'fa-clock', 'title' => 'Time-Saving', 'desc' => 'Quickly search and manage plots without manual paperwork.', 'color' => '#f39c12'],
                ['icon' => 'fa-users', 'title' => 'Family Support', 'desc' => 'Provide assistance and transportation to families visiting the graveyard.', 'color' => '#1abc9c']
            ] as $feature)
            <div class="col-md-4">
                <div class="feature-box p-4 bg-white shadow-sm rounded-4 h-100">
                    <i class="fas {{ $feature['icon'] }} fa-2x mb-3 icon-colored" style="color: {{ $feature['color'] }}"></i>
                    <h5 class="fw-semibold mb-2">{{ $feature['title'] }}</h5>
                    <p class="text-muted">{{ $feature['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

</div>
@endsection

<style>
/* Whole page background */
.about-wrapper {
    background-color: #f1f3f6; /* soft light gray */
    padding-bottom: 4%;
}

/* Gradient background for hero */
.bg-gradient {
    background: linear-gradient(to bottom, #f0fff4, #ffffff);
}

/* Hero image size */
.hero-image {
    width: 100%;       /* fill the column width */
    max-width: 100%;   /* ensure it doesn't exceed column */
    height: 400px;     /* make it taller */
    object-fit: cover; /* maintain aspect ratio, cover area */
}


/* Image frame corner dots */
.image-frame .corner-dot {
    position: absolute;
    width: 12px;
    height: 12px;
    background-color: #198754;
    border-radius: 50%;
}
.image-frame .top-left {
    top: 0;
    left: 0;
    transform: translate(-50%, -50%);
}
.image-frame .bottom-right {
    bottom: 0;
    right: 0;
    transform: translate(50%, 50%);
}

/* Check icon animation */


.icon-bounce {
    animation: bounce 0.6s ease-in-out;
}

/* Feature icon hover glow */
.icon-glow {
    transition: all 0.3s ease;
}
.icon-glow:hover {
    color: #27c985;
    text-shadow: 0 0 8px rgba(39, 201, 133, 0.4);
}

/* Feature box hover */
.feature-box:hover {
    transform: translateY(-4px);
    transition: all 0.3s ease;
    box-shadow: 0 8px 24px rgba(0,0,0,0.1);
}

/* Bounce animation */
@keyframes bounce {
    0% { transform: scale(1); }
    50% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>
