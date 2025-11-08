<!-- Footer -->
<footer class="bg-dark text-light py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h5 class="mb-3">About Us</h5>
                <p>JetCartridge is a leading B2B marketplace connecting buyers with verified suppliers worldwide.
                </p>
            </div>
            <div class="col-md-3">
                <h5 class="mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('categories') }}" class="text-light text-decoration-none">Product Categories</a></li>
                    <li><a href="{{ route('sellers') }}" class="text-light text-decoration-none">Verified Sellers</a></li>
                    <li><a href="{{ route('manufacturers') }}" class="text-light text-decoration-none">Manufacturers</a></li>
                    <li><a href="{{ route('resources') }}" class="text-light text-decoration-none">Resources</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-3">Customer Service</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('faq') }}" class="text-light text-decoration-none">Help Center</a></li>
                    <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contact Us</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Report IPR</a></li>
                    <li><a href="{{ route('privacy') }}" class="text-light text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h5 class="mb-3">Legal</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('terms') }}" class="text-light text-decoration-none">Terms of Service</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Trade Assurance</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Business Identity</a></li>
                    <li><a href="#" class="text-light text-decoration-none">Production Monitoring</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p class="mb-0">&copy; 2024 JetCartridge. All rights reserved.</p>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>