@extends('layouts.app')

@section('content')

{{-- Success Message --}}
@if(session('success'))
<div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    max-width: 400px;
    z-index: 1050;
    box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
    border-radius: 8px;
    font-weight: 500;
    font-size: 0.95rem;
    padding: 0.5rem 1rem;
">      
    {{ session('success') }}
</div>
@endif

<!-- Hero Header -->
<section class="py-5 hero-gradient text-dark">
    <div class="container text-center">
        <div class="mb-3">
            <i class="fas fa-envelope-open-text fa-3x icon-pulse"></i>
        </div>
        <h3 class="display-5 fw-bold mb-2">Get In Touch</h3>
        <p class="lead text-muted">Have questions, feedback, or support requests? We’re here to help.</p>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5" style="background-color: #F5F2E7;">
    <div class="container">
        <div class="row g-5">

            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="card shadow-sm rounded-4 p-4 h-100 contact-card bg-white border-0">
                    <h4 class="fw-bold mb-4">📍 Our Office</h4>

                    <div class="d-flex mb-4">
                        <i class="fas fa-map-marker-alt text-success me-3 icon-contact"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">Baldia Town</h6>
                            <p class="text-muted">Karachi, Pakistan</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <i class="fas fa-phone-alt text-secondary me-3 icon-contact"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">
                                <a href="https://web.whatsapp.com/" target="_blank" class="text-decoration-none text-dark">+92 331 2115184</a>
                            </h6>
                            <p class="text-muted">Mon–Fri, 8AM–5PM</p>
                        </div>
                    </div>

                    <div class="d-flex mb-4">
                        <i class="fas fa-envelope text-danger me-3 icon-contact"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">
                                <a href="mailto:waseemkhan16537@gamil.pk" class="text-decoration-none text-dark">waseemkhan16537@gamil.pk</a>
                            </h6>
                            <p class="text-muted">Email us anytime</p>
                        </div>
                    </div>

                    <h6 class="fw-semibold text-primary mb-2">Locate Us</h6>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.94871740384!2d66.95718727454184!3d24.933816877881416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb36b2e3261f397%3A0xff46218169b932ee!2sShamsabad%20Shahpur%20Muslim%20Jamat%20Baldia%20Rabta%20Office!5e0!3m2!1sen!2s!4v1761044487228!5m2!1sen!2s" 
                        width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" class="rounded shadow-sm"></iframe>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="card shadow-sm rounded-4 p-4 bg-white border-0 contact-card">
                    <h4 class="fw-bold mb-4 ">✉️ Send Us a Message</h4>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-3 shadow-sm" placeholder="Your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3 shadow-sm" placeholder="you@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" class="form-control rounded-3 shadow-sm" placeholder="Reason for contact" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea name="message" rows="5" class="form-control rounded-3 shadow-sm" placeholder="Write your message..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-sage fw-bold rounded-pill px-4 py-2">
    Send Message
</button>


                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    setTimeout(function() {
        const alert = document.getElementById('success-alert');
        if (alert) {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 4000);
</script>

@endsection

<style>
/* === COLORS === */
.text-sage { color: #A3B18A !important; }
.text-beige { color: #EDE6D0 !important; }

.hero-gradient {
    background: linear-gradient(135deg, #EDE6D0, #A3B18A);
    padding: 5rem 0;
}

/* Button */

.btn.btn-sage {
    background-color: #7e9163 !important;
    color: #fff !important;
    transition: all 0.3s ease;
}

.btn.btn-sage:hover {
    background-color: #8a9674 !important;
    color: #fff !important;
}


/* Contact Card */
.contact-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

/* Icons */
.icon-contact {
    font-size: 1.4rem;
    transition: transform 0.3s ease, color 0.3s ease;
}
.icon-contact:hover {
    transform: scale(1.2);
    color: #A3B18A;
}

/* Icon animation */
.icon-pulse {
    animation: pulse 2s infinite;
    color: #6B705C;
}
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}

/* Responsive */
@media (max-width: 991px) {
    .hero-gradient {
        padding: 3rem 1rem;
    }
}
</style>
