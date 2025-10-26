@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Hero Section -->
    <section class="hero-section position-relative" style="height: 500px; overflow: hidden;">
        <img src="{{ asset('images/b.png') }}" class="img-fluid w-100 h-100" style="object-fit: cover;" alt="Graveyard Hero Image">
        <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-3"
             style="background-color: rgba(0, 0, 0, 0.6); padding: 30px; border-radius: 12px; max-width: 90%;">
            <h2 class="display-5 fw-bold mb-3">Attock Graveyard Management System</h2>
            <p class="lead mb-3">Preserving legacy with care, dignity, and digital precision.</p>
            <a href="{{ route('login') }}" class="btn btn-light fw-bold px-4 py-2">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
<section class="features-section py-5 bg-light mt-5 mb-5">
    <div class="container">
        <h2 class="text-center fw-bold mb-4">What You Can Do</h2>
        <div class="row g-4">

            <!-- Search Burial Records -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- <img src="{{ asset('images/burial-records.jpg') }}" class="card-img-top" alt="Burial Records"> --}}
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <i class="fas fa-search me-2 text-primary"></i> Search Burial Records
                        </h5>
                        <p class="card-text">Find detailed records of those buried, including names, dates, and plot locations.</p>
                        <a href="#" class="btn btn-outline-dark">Explore Records</a>
                    </div>
                </div>
            </div>

            <!-- Manage Graveyard Plots -->
            {{-- <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('images/plot-management.jpg') }}" class="card-img-top" alt="Plot Management">
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <i class="fas fa-map me-2 text-success"></i> Manage Graveyard Plots
                        </h5>
                        <p class="card-text">Assign, reserve, and update plot statuses with ease using our digital tools.</p>
                        <a href="#" class="btn btn-outline-dark">Manage Plots</a>
                    </div>
                </div>
            </div> --}}
            <!-- Grave Reservation -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- <img src="{{ asset('images/grave-reservation.jpg') }}" class="card-img-top" alt="Grave Reservation"> --}}
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <i class="fas fa-cross me-2 text-secondary"></i> Grave Reservation
                        </h5>
                        <p class="card-text">Reserve a grave at Attock GMS with verified plot details and documentation.</p>
                        <a href="#" class="btn btn-outline-dark">Reserve Now</a>
                    </div>
                </div>
            </div>
            

             <!-- Transportation -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- <img src="{{ asset('images/transportation.jpg') }}" class="card-img-top" alt="Transportation"> --}}
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <i class="fas fa-bus me-2 text-warning"></i> Family Transportation
                        </h5>
                        <p class="card-text">Provide transport for family members and relatives attending the funeral.</p>
                        <a href="#" class="btn btn-outline-dark">Arrange Transport</a>
                    </div>
                </div>
            </div>



             <!-- Marble Finishing -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- <img src="{{ asset('images/marble-finishing.jpg') }}" class="card-img-top" alt="Marble Finishing"> --}}
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <i class="fas fa-th-large me-2 text-info"></i> Marble Finishing
                        </h5>
                        <p class="card-text">Add premium marble finishing to graves upon request for a respectful presentation.</p>
                        <a href="#" class="btn btn-outline-dark">Customize Grave</a>
                    </div>
                </div>
            </div>


            <!-- Get Support -->
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    {{-- <img src="{{ asset('images/support.jpg') }}" class="card-img-top" alt="Support"> --}}
                    <div class="card-body">
                        <h5 class="card-title fw-semibold">
                            <i class="fas fa-headset me-2 text-danger"></i> Get Support
                        </h5>
                        <p class="card-text">Need help? Reach out to our team for assistance with records, access, or technical issues.</p>
                        <a href="{{ route('contact') }}" class="btn btn-outline-dark">Contact Us</a>
                    </div>
                </div>
            </div>




        </div>
    </div>
</section>


    <!-- Call to Action -->
    <section class="cta-section bg-dark text-white text-center py-5">
        <h3 class="fw-bold">Join the mission to preserve heritage</h3>
        <p class="mb-4">Digitally manage graveyard data and honor those who came before us.</p>
        <a href="{{ route('register') }}" class="btn btn-light fw-bold px-4 py-2">Create an Account</a>
    </section>
</div>
@endsection
