{{-- Footer goes here --}}
    <footer class="bg-dark text-white pt-4 pb-3 mt-5">
        <div class="container">
            <div class="row text-center text-md-start">
                <!-- About -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-warning">About Us</h5>
                    <p class="small text-light">
                        Attock Graveyard Management System is committed to respectful service and community care.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-warning">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="{{ url('/') }}" class="text-light text-decoration-none">Home</a></li>
                        <li><a href="{{ url('/contact') }}" class="text-light text-decoration-none">Contact</a></li>
                        <li><a href="{{ url('/services') }}" class="text-light text-decoration-none">Services</a></li>
                        <li><a href="{{ url('/about') }}" class="text-light text-decoration-none">About</a></li>
                    </ul>
                </div>

                <!-- Stay Connected -->
                <div class="col-md-4 mb-3">
                    <h5 class="text-warning">Stay Connected</h5>
                    <div class="d-flex justify-content-center justify-content-md-start gap-3 mb-2">
                        <a href="#" class="text-light"><i class="fab fa-facebook fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-twitter fa-lg"></i></a>
                        <a href="#" class="text-light"><i class="fa fa-envelope fa-lg"></i></a>
                    </div>
                    <p class="small mb-0">Email: <a href="mailto:info@attockgraveyard.pk" class="text-light text-decoration-none">info@attockgraveyard.pk</a></p>
                </div>
            </div>

            <hr class="border-light mt-4">

            <!-- Copyright -->
            <div class="text-center">
                <small class="">&copy; {{ date('Y') }} Attock Graveyard Management System. All rights reserved.</small>
            </div>
        </div>
    </footer>