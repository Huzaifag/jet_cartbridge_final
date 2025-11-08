@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Privacy Policy</h1>
                <p class="lead text-muted">How we collect, use, and protect your personal information</p>
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
                        <h2 class="h3 mb-3">1. Information We Collect</h2>
                        <h5 class="mb-3">Personal Information</h5>
                        <p>We may collect the following personal information:</p>
                        <ul>
                            <li>Name, email address, and contact information</li>
                            <li>Business information (company name, address, tax ID)</li>
                            <li>Payment information and billing details</li>
                            <li>Shipping and delivery addresses</li>
                            <li>Account credentials and preferences</li>
                        </ul>

                        <h5 class="mb-3 mt-4">Usage Information</h5>
                        <p>We automatically collect certain information when you use our platform:</p>
                        <ul>
                            <li>IP address and location data</li>
                            <li>Browser type and version</li>
                            <li>Pages visited and time spent on our site</li>
                            <li>Device information and screen resolution</li>
                            <li>Referral sources and clickstream data</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">2. How We Use Your Information</h2>
                        <p>We use the collected information for the following purposes:</p>
                        <ul>
                            <li>To provide and maintain our services</li>
                            <li>To process transactions and manage orders</li>
                            <li>To communicate with you about your account and orders</li>
                            <li>To send marketing communications (with your consent)</li>
                            <li>To improve our platform and develop new features</li>
                            <li>To ensure security and prevent fraud</li>
                            <li>To comply with legal obligations</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">3. Information Sharing</h2>
                        <p>We do not sell, trade, or otherwise transfer your personal information to third parties except in the following cases:</p>
                        <ul>
                            <li><strong>Service Providers:</strong> With trusted third-party service providers who assist us in operating our platform</li>
                            <li><strong>Business Partners:</strong> With business partners for order fulfillment and delivery</li>
                            <li><strong>Legal Requirements:</strong> When required by law or to protect our rights</li>
                            <li><strong>Business Transfers:</strong> In connection with a merger, acquisition, or sale of assets</li>
                            <li><strong>With Consent:</strong> When you explicitly consent to the sharing</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">4. Data Security</h2>
                        <p>
                            We implement appropriate technical and organizational measures to protect your personal information
                            against unauthorized access, alteration, disclosure, or destruction. These measures include:
                        </p>
                        <ul>
                            <li>SSL/TLS encryption for data transmission</li>
                            <li>Secure data storage with access controls</li>
                            <li>Regular security audits and updates</li>
                            <li>Employee training on data protection</li>
                            <li>Incident response procedures</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">5. Cookies and Tracking</h2>
                        <p>
                            We use cookies and similar technologies to enhance your experience on our platform.
                            You can control cookie settings through your browser preferences.
                        </p>
                        <p><strong>Types of cookies we use:</strong></p>
                        <ul>
                            <li><strong>Essential Cookies:</strong> Required for basic platform functionality</li>
                            <li><strong>Analytics Cookies:</strong> Help us understand how you use our platform</li>
                            <li><strong>Marketing Cookies:</strong> Used to deliver relevant advertisements</li>
                            <li><strong>Preference Cookies:</strong> Remember your settings and preferences</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">6. Your Rights</h2>
                        <p>You have the following rights regarding your personal information:</p>
                        <ul>
                            <li><strong>Access:</strong> Request a copy of your personal information</li>
                            <li><strong>Correction:</strong> Request correction of inaccurate information</li>
                            <li><strong>Deletion:</strong> Request deletion of your personal information</li>
                            <li><strong>Portability:</strong> Request transfer of your data to another service</li>
                            <li><strong>Objection:</strong> Object to processing of your personal information</li>
                            <li><strong>Restriction:</strong> Request limitation of how we process your information</li>
                        </ul>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">7. Data Retention</h2>
                        <p>
                            We retain your personal information for as long as necessary to provide our services,
                            comply with legal obligations, resolve disputes, and enforce our agreements. Specific
                            retention periods vary depending on the type of information and the purpose for which it was collected.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">8. International Data Transfers</h2>
                        <p>
                            Your information may be transferred to and processed in countries other than your own.
                            We ensure that such transfers comply with applicable data protection laws and implement
                            appropriate safeguards to protect your information.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">9. Children's Privacy</h2>
                        <p>
                            Our services are not intended for children under 13 years of age. We do not knowingly
                            collect personal information from children under 13. If we become aware that we have
                            collected personal information from a child under 13, we will take steps to delete such information.
                        </p>
                    </section>

                    <section class="mb-5">
                        <h2 class="h3 mb-3">10. Changes to This Policy</h2>
                        <p>
                            We may update this Privacy Policy from time to time. We will notify you of any changes
                            by posting the new Privacy Policy on this page and updating the "Last updated" date.
                            You are advised to review this Privacy Policy periodically for any changes.
                        </p>
                    </section>

                    <section>
                        <h2 class="h3 mb-3">11. Contact Us</h2>
                        <p>
                            If you have any questions about this Privacy Policy or our data practices, please contact us:
                        </p>
                        <ul class="list-unstyled">
                            <li><strong>Email:</strong> privacy@jetcartridge.com</li>
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
