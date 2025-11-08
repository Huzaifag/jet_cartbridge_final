@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Contact Us</h1>
                <p class="lead text-muted">Get in touch with our team for support and inquiries</p>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">Send us a Message</h2>
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" required>
                            </div>
                            <div class="col-12">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-geo-alt-fill fs-2 text-primary me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Our Office</h5>
                                    <p class="text-muted mb-0">
                                        123 Business District<br>
                                        New York, NY 10001<br>
                                        United States
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-telephone-fill fs-2 text-success me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Phone</h5>
                                    <p class="text-muted mb-0">
                                        +1 (555) 123-4567<br>
                                        +1 (555) 123-4568 (Support)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-envelope-fill fs-2 text-info me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Email</h5>
                                    <p class="text-muted mb-0">
                                        support@jetcartridge.com<br>
                                        sales@jetcartridge.com
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-clock-fill fs-2 text-warning me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Business Hours</h5>
                                    <p class="text-muted mb-0">
                                        Monday - Friday: 9:00 AM - 6:00 PM EST<br>
                                        Saturday: 10:00 AM - 4:00 PM EST<br>
                                        Sunday: Closed
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="h4 mb-4">Frequently Asked Questions</h2>
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    How do I create an account?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You can create an account by clicking on "Sign Up" in the top navigation.
                                    Choose your account type (Buyer, Seller, or Manufacturer) and follow the registration process.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    How do I place an order?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Browse products, add items to your cart, and proceed to checkout.
                                    You'll need to provide shipping information and payment details.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    What payment methods do you accept?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We accept major credit cards, PayPal, bank transfers, and other secure payment methods.
                                    All transactions are protected by our secure payment system.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
