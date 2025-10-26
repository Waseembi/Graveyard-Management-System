@extends('layouts.app')

@section('content')
<section class="py-5 bg-light" style="margin-top: 45px;">
    <div class="container">
        <div class="row align-items-center g-5">
            <!-- Text Content -->
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Attock Graveyard Management System</h2>
                <p class="text-muted mb-3">
                    Our system was built with a clear mission: to bring dignity, clarity, and ease to the process of managing graveyard records. We combine thoughtful design with reliable technology to help communities preserve legacy and honor those who came before.
                </p>
                <p class="text-muted mb-3">
                    Whether you're searching for burial records, managing plot availability, or simply seeking support, our platform ensures everything is handled with care and respect.
                </p>
                <p class="text-muted">
                    Because every life deserves to be remembered—and every record deserves to be accurate.
                </p>
            </div>

            <!-- Image -->
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/cbanner.png') }}" alt="Graveyard Image" class="img-fluid rounded shadow-sm" style="max-height: 400px; object-fit: cover;">
            </div>
        </div>
    </div>
</section>
@endsection
