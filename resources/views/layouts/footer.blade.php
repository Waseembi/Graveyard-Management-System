{{-- Elegant Emerald Footer --}}
<footer class="footer-section pt-3 pb-2" >
    <div class="container" >
        <div class="row g-4 text-center text-md-start">

            <!-- About -->
            <div class="col-md-4">
                <h5 class="footer-heading">Attock GMS</h5>
                <p class="footer-description">
                    A respectful platform for managing graveyard records, preserving legacy, and serving the community with dignity.
                </p>
                <div class="footer-social mt-3">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="mailto:info@attockgraveyard.pk" class="social-icon"><i class="fas fa-envelope"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-4">
                <h5 class="footer-heading">Quick Links</h5>
                <ul class="list-unstyled footer-links mt-2">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ url('/contact') }}">Contact</a></li>
                    <li><a href="{{ url('/services') }}">Services</a></li>
                    <li><a href="{{ url('/about') }}">About</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-4">
                <h5 class="footer-heading">Contact</h5>
                <p class="footer-description mb-1">Email us anytime:</p>
                <a href="mailto:info@attockgraveyard.pk" class="footer-email">info@attockgraveyard.pk</a>
            </div>

        </div>

        <hr class="footer-divider mt-2 ">

        <div class="text-center mt-2">
            <small class="footer-copy">&copy; {{ date('Y') }} Attock Graveyard Management System. All rights reserved.</small>
        </div>
    </div>
</footer>

<style>
.footer-section {
    background-color: #121212;
    color: #eaeaea;
    font-family: 'Segoe UI', sans-serif;
    border-top: 1px solid #198754;
    box-shadow: 0 -2px 12px rgba(0,0,0,0.2);
}

.footer-heading {
    color: #27c985;
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.footer-description {
    font-size: 0.9rem;
    color: #bfbfbf;
    line-height: 1.6;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: #eaeaea;
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.footer-links a:hover {
    color: #27c985;
    text-decoration: underline;
}

.footer-email {
    color: #27c985;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-email:hover {
    color: #198754;
    text-decoration: underline;
}

.footer-social .social-icon {
    color: #eaeaea;
    font-size: 1.2rem;
    margin-right: 12px;
    transition: color 0.3s ease, transform 0.3s ease;
}

.footer-social .social-icon:hover {
    color: #27c985;
    transform: scale(1.1);
}

.footer-divider {
    border-color: #cec6c6;
}

.footer-copy {
    color: #888;
    font-size: 0.85rem;
}
</style>
