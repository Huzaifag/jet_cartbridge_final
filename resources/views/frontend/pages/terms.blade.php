@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Terms of Service</h1>
                <p class="lead text-muted">Please read these terms carefully before using our platform</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="mb-4">
                        <p class="text-muted">Last updated: {{ date('F j, Y') }}</p>
                    </div>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">1. Acceptance of Terms</h2>
                        <p>
                            By accessing and using Jet Cartridge, you accept and agree to be bound by the terms
                            and provision of this agreement. If you do not agree to abide by the above,
                            please do not use this service.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">2. User Accounts</h2>
                        <p>
                            When you create an account with us, you must provide information that is accurate,
                            complete, and current at all times. You are responsible for safeguarding the password
                            and for all activities that occur under your account.
                        </p>
                        <p>
                            You must notify us immediately upon becoming aware of any breach of security or
                            unauthorized use of your account.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">3. Prohibited Uses</h2>
                        <p>You may not use our service:</p>
                        <ul>
                            <li>For any unlawful purpose or to solicit others to perform unlawful acts</li>
                            <li>To violate any international, federal, provincial, or state regulations, rules, laws, or local ordinances</li>
                            <li>To infringe upon or violate our intellectual property rights or the intellectual property rights of others</li>
                            <li>To harass, abuse, insult, harm, defame, slander, disparage, intimidate, or discriminate</li>
                            <li>To submit false or misleading information</li>
                            <li>To upload or transmit viruses or any other type of malicious code</li>
                            <li>To spam, phish, pharm, pretext, spider, crawl, or scrape</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">4. Products and Services</h2>
                        <p>
                            All products and services are subject to availability. We reserve the right to
                            discontinue any product or service at any time. Prices for our products are
                            subject to change without notice.
                        </p>
                        <p>
                            We have made every effort to display as accurately as possible the colors and
                            images of our products. We cannot guarantee that your computer monitor's display
                            of any color will be accurate.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">5. Billing and Account Information</h2>
                        <p>
                            You agree to provide current, complete, and accurate purchase and account information
                            for all purchases made at our store. You agree to promptly update your account and
                            other information, including your email address and credit card numbers and expiration
                            dates, so that we can complete your transactions and contact you as needed.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">6. Returns and Refunds</h2>
                        <p>
                            We offer returns within 30 days of purchase for most items, subject to our return policy.
                            Items must be in their original condition and packaging. Custom orders may not be eligible
                            for return unless there is a manufacturing defect.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">7. Limitation of Liability</h2>
                        <p>
                            In no case shall Jet Cartridge, our directors, officers, employees, affiliates, agents,
                            contractors, interns, suppliers, service providers or licensors be liable for any injury,
                            loss, claim, or any direct, indirect, incidental, punitive, special, or consequential damages
                            of any kind.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">8. Termination</h2>
                        <p>
                            We may terminate or suspend your account and bar access to the service immediately,
                            without prior notice or liability, under our sole discretion, for any reason whatsoever
                            and without limitation, including but not limited to a breach of the Terms.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">9. Governing Law</h2>
                        <p>
                            These Terms of Service and any separate agreements whereby we provide you services
                            shall be governed by and construed in accordance with the laws of the United States.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">10. Changes to Terms</h2>
                        <p>
                            We reserve the right, at our sole discretion, to modify or replace these Terms at any time.
                            If a revision is material, we will provide at least 30 days notice prior to any new terms
                            taking effect.
                        </p>
                    </section>

                    <section>
                        <h2 class="h3 mb-3">11. Contact Information</h2>
                        <p>
                            If you have any questions about these Terms of Service, please contact us at:
                        </p>
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> legal@jetcartridge.com</li>
                            <li><strong>Phone:</strong> +1 (555) 123-4567</li>
                            <li><strong>Address:</strong> 123 Business District, New York, NY 10001</li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
