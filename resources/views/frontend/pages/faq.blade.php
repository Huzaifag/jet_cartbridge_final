@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Frequently Asked Questions</h1>
                <p class="lead text-muted">Find answers to common questions about Jet Cartridge</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="accordion" id="faqAccordion">
                <!-- Getting Started -->
                <div class="mb-4">
                    <h2 class="h4 mb-3 text-primary">Getting Started</h2>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                How do I create an account on Jet Cartridge?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                To create an account, click on "Sign Up" in the top navigation bar. Choose your account type
                                (Buyer, Seller, or Manufacturer) and fill out the registration form with your basic information.
                                You'll receive a confirmation email to verify your account.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                What types of accounts are available?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer three types of accounts:
                                <ul>
                                    <li><strong>Buyer:</strong> For businesses looking to purchase products</li>
                                    <li><strong>Seller:</strong> For suppliers and distributors</li>
                                    <li><strong>Manufacturer:</strong> For companies that produce goods</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                Is registration free?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Yes, basic registration is completely free for all account types. Some premium features
                                may require a subscription, but you can browse and use basic platform features at no cost.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Buying Products -->
                <div class="mb-4">
                    <h2 class="h4 mb-3 text-primary">Buying Products</h2>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
                                How do I search for products?
                            </button>
                        </h2>
                        <div id="faq4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can search for products using the search bar at the top of the page, browse by categories,
                                or use our advanced filters to narrow down results by price, rating, location, and seller type.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
                                How do I place an order?
                            </button>
                        </h2>
                        <div id="faq5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                1. Add products to your cart<br>
                                2. Review your cart and proceed to checkout<br>
                                3. Select or add a shipping address<br>
                                4. Choose your payment method<br>
                                5. Review and confirm your order
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="faq6" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We accept major credit cards (Visa, MasterCard, American Express), PayPal, bank transfers,
                                and other secure payment methods. All transactions are protected by our secure payment system.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Selling Products -->
                <div class="mb-4">
                    <h2 class="h4 mb-3 text-primary">Selling Products</h2>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq7">
                                How do I list my products?
                            </button>
                        </h2>
                        <div id="faq7" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                After creating a seller account, go to your dashboard and click "Add Product".
                                Fill in the product details, upload images, set pricing, and publish your listing.
                                All products go through a verification process before being published.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq8">
                                What are the fees for selling?
                            </button>
                        </h2>
                        <div id="faq8" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Basic listing is free. We charge a small commission on successful sales (typically 5-10%
                                depending on your subscription plan). Premium sellers get lower commission rates and additional features.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq9">
                                How do I get verified as a seller?
                            </button>
                        </h2>
                        <div id="faq9" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Submit your business documents (business license, tax ID, etc.) through your seller dashboard.
                                Our verification team will review your documents within 2-3 business days.
                                Verified sellers get a badge and increased visibility.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Orders & Shipping -->
                <div class="mb-4">
                    <h2 class="h4 mb-3 text-primary">Orders & Shipping</h2>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq10">
                                How do I track my order?
                            </button>
                        </h2>
                        <div id="faq10" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can track your orders from your account dashboard under "Order History" or use the
                                "Track Order" feature. You'll receive email updates at each stage of the shipping process.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq11">
                                What are your shipping options?
                            </button>
                        </h2>
                        <div id="faq11" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer various shipping options including standard, express, and freight shipping.
                                Shipping costs and delivery times vary by location and product type. International
                                shipping is available to most countries.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq12">
                                What is your return policy?
                            </button>
                        </h2>
                        <div id="faq12" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                We offer a 30-day return policy for most items. Items must be in original condition
                                and packaging. Return shipping costs may apply depending on the reason for return.
                                Custom orders may have different return terms.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Support & Technical -->
                <div class="mb-4">
                    <h2 class="h4 mb-3 text-primary">Support & Technical</h2>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq13">
                                How do I contact customer support?
                            </button>
                        </h2>
                        <div id="faq13" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can contact our support team through:
                                <ul>
                                    <li>Email: support@jetcartridge.com</li>
                                    <li>Phone: +1 (555) 123-4567</li>
                                    <li>Live chat on our website</li>
                                    <li>Contact form on our website</li>
                                </ul>
                                Our support hours are Monday-Friday, 9 AM - 6 PM EST.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq14">
                                I forgot my password. What should I do?
                            </button>
                        </h2>
                        <div id="faq14" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Click on "Login" and then "Forgot Password". Enter your email address and we'll send
                                you a password reset link. Follow the instructions in the email to create a new password.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq15">
                                How do I report a problem with a product or seller?
                            </button>
                        </h2>
                        <div id="faq15" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                You can report issues through your account dashboard under "Support" or by contacting
                                our support team directly. Please provide as much detail as possible, including order
                                numbers and specific issues you're experiencing.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="card shadow-sm border-0 mt-5">
                <div class="card-body p-4 text-center">
                    <h3 class="h5 mb-3">Still have questions?</h3>
                    <p class="text-muted mb-4">
                        Can't find the answer you're looking for? Our support team is here to help.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('contact') }}" class="btn btn-primary">Contact Support</a>
                        <a href="mailto:support@jetcartridge.com" class="btn btn-outline-primary">Email Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
