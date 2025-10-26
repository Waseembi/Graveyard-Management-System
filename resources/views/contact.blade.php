@extends('layouts.app')

{{-- success message --}}
        @if(session('success'))
            <div id="success-alert" class="alert alert-success text-center mx-auto mt-5" style="
                position: absolute;
                top: 20px;
                left: 50%;
                transform: translateX(-50%);
                max-width: 400px;
                z-index: 1050;
                box-shadow: 0 0.5rem 1rem rgba(0, 128, 0, 0.2);
                border-radius: 6px;
                font-weight: 500;
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
                line-height: 1.3;
            ">      
                 {{ session('success') }}
        </div>
        @endif

@section('content')

<!-- Hero Header -->
<section class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #2c2c2c, #3a3a3a);">
    <div class="container text-center position-relative" style="z-index: 2;">

        <div class="mb-4">
            <i class="fa fa-comments fa-3x text-warning animate-pulse"></i>
        </div>

        <h2 class="fw-bold display-5 mb-3">Let’s Connect</h2>
        <p class="fs-5 text-light">Whether you have a question, feedback, or need support — we’re here to listen and help.</p>
    </div>
    
</section>

<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="bg-white shadow rounded-4 p-4 h-100">
                    <h4 class="fw-bold mb-4 text-primary">📍 Our Office</h4>

                    <div class="mb-4 d-flex align-items-start">
                        <i class="fa fa-map-marker fa-lg text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">Baldia Town</h6>
                            <p class="text-muted">Karachi, Pakistan</p>
                        </div>
                    </div>

                    <div class="mb-4 d-flex align-items-start">
                        <i class="fa fa-phone fa-lg text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">
                                <a href="https://web.whatsapp.com/" target="_blank" class="text-decoration-none text-dark">+92 331 2115184</a>
                            </h6>
                            <p class="text-muted">Mon–Fri, 8AM–5PM</p>
                        </div>
                    </div>

                    <div class="mb-4 d-flex align-items-start">
                        <i class="fa fa-envelope fa-lg text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1 fw-semibold">
                                <a href="mailto:waseemkhan16537@gamil.pk" class="text-decoration-none text-dark">waseemkhan16537@gamil.pk</a>
                            </h6>
                            <p class="text-muted">Email us anytime</p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="fw-semibold text-primary">Find Us on the Map</h6>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.94871740384!2d66.95718727454184!3d24.933816877881416!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb36b2e3261f397%3A0xff46218169b932ee!2sShamsabad%20Shahpur%20Muslim%20Jamat%20Baldia%20Rabta%20Office!5e0!3m2!1sen!2s!4v1761044487228!5m2!1sen!2s" width="400" height="380" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            
                    </div>
                </div>
            </div>



            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="bg-white shadow rounded-4 p-4">
                    <h4 class="fw-bold mb-4 text-primary">✉️ Send Us a Message</h4>
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="Your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Email Address</label>
                            <input type="email" name="email" class="form-control rounded-3" placeholder="you@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Subject</label>
                            <input type="text" name="subject" class="form-control rounded-3" placeholder="e.g. Admission, Grave Plot, Feedback" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Message</label>
                            <textarea name="message" rows="5" class="form-control rounded-3" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold rounded-pill">Send Message</button>
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



















{{-- 
 @extends('layouts.app')

@section('content')

<!-- Contact Section -->
<section class="py-5 text-white position-relative" style="background: linear-gradient(135deg, #302f2f, #343a40);">
    <div class="container position-relative" style="z-index: 2;">
        <!-- Header -->
        <div class="text-center mb-5">
            <div class="mb-3">
                <i class="fa fa-comments fa-3x text-warning"></i>
            </div>
            <h2 class="fw-bold display-5">Let’s Connect</h2>
            <p class="fs-5 text-light">Have questions, suggestions, or need help? We’re here for you.</p>
        </div>
    </div>
</section>



<!-- Contact Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-5">
            <!-- Contact Info -->
            <div class="col-lg-5">
                <div class="bg-white shadow-sm rounded p-4 h-100">
                    <h4 class="fw-bold mb-4">📍 Our Office</h4>
                    <div class="mb-3 d-flex align-items-start">
                        <i class="fa fa-map-marker fa-lg text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1">Baldia Town</h6>
                            <p class="text-muted">Karachi, Pakistan</p>
                        </div>
                    </div>
                    <div class="mb-3 d-flex align-items-start">
                        <i class="fa fa-phone fa-lg text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1"><a href="https://web.whatsapp.com/" target="_blank">+92 331 2115184</a></h6>
                            <p class="text-muted">Mon–Fri, 8AM–5PM</p>
                        </div>
                    </div>
                    <div class="mb-3 d-flex align-items-start">
                        <i class="fa fa-envelope fa-lg text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="mb-1"><a href="mailto:waseemkhan16537@gamil.pk">waseemkhan16537@gamil.pk</a></h6>
                            <p class="text-muted">Email us anytime</p>
                        </div>
                    </div>
                    <div class="mt-4">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3617.5953502709117!2d66.93118787414414!3d24.945851341837677!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3eb36b7707d53b75%3A0x6f1ad08b910829d8!2sNaval%20colony%20baldia%20town!5e0!3m2!1sen!2s!4v1717573805526!5m2!1sen!2s"
                            width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" class="rounded"></iframe>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-7">
                <div class="bg-white shadow-sm rounded p-4">
                    <h4 class="fw-bold mb-4">✉️ Send Us a Message</h4>
                    <form method="POST" action="#">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Your name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email" name="email" class="form-control" placeholder="you@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="e.g. Admission, Grave Plot, Feedback" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Message</label>
                            <textarea name="message" rows="5" class="form-control" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 py-2 fw-bold">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection  --}}




{{-- ✅ Toast notification on form submission

✅ Validation feedback

✅ Google reCAPTCHA

✅ Save messages to database or send email --}}