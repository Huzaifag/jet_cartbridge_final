@extends('frontend.layout.main')

@section('content')
<!-- Premium Hero Section -->
<section class="premium-hero">
    <div class="premium-container">
        <div class="premium-hero-content">
            <h1 class="premium-hero-title">About <span class="accent-text">Jet Cartridge</span></h1>
            <p class="premium-hero-subtitle">Connecting businesses worldwide through innovative B2B marketplace solutions</p>
        </div>
    </div>
</section>

<!-- Premium Mission Section -->
<section class="premium-section">
    <div class="premium-container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="premium-card text-center">
                    <h2 class="premium-card-title mb-4">Our Mission</h2>
                    <p class="premium-card-text mb-4" style="font-size: 1.1rem; line-height: 1.8;">
                        Jet Cartridge is a premier B2B marketplace platform designed to revolutionize how businesses connect,
                        trade, and grow. We bridge the gap between manufacturers, suppliers, and buyers worldwide,
                        creating seamless trading experiences through cutting-edge technology and trusted partnerships.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Premium What We Do Section -->
<section class="premium-section">
    <div class="premium-container">
        <div class="premium-header">
            <h2 class="premium-title">What We <span class="accent-text">Do</span></h2>
            <p class="premium-subtitle">Comprehensive solutions for modern B2B trading</p>
        </div>
        
        <div class="premium-grid premium-grid-2">
            <div class="premium-card premium-fade-in">
                <i class="fas fa-store premium-card-icon"></i>
                <h3 class="premium-card-title">Verified Suppliers</h3>
                <p class="premium-card-text">Connect with pre-verified manufacturers and suppliers globally.</p>
            </div>
            <div class="premium-card premium-fade-in">
                <i class="fas fa-shield-alt premium-card-icon"></i>
                <h3 class="premium-card-title">Secure Transactions</h3>
                <p class="premium-card-text">Protected payment systems and trade assurance programs.</p>
            </div>
            <div class="premium-card premium-fade-in">
                <i class="fas fa-globe premium-card-icon"></i>
                <h3 class="premium-card-title">Global Reach</h3>
                <p class="premium-card-text">Access international markets and expand your business horizons.</p>
            </div>
            <div class="premium-card premium-fade-in">
                <i class="fas fa-chart-line premium-card-icon"></i>
                <h3 class="premium-card-title">Business Intelligence</h3>
                <p class="premium-card-text">Data-driven insights to optimize your trading decisions.</p>
            </div>
        </div>
    </div>
</section>

<!-- Premium Why Choose Us Section -->
<section class="premium-section">
    <div class="premium-container">
        <div class="premium-header">
            <h2 class="premium-title">Why Choose <span class="accent-text">Jet Cartridge</span>?</h2>
            <p class="premium-subtitle">Excellence in every aspect of B2B trading</p>
        </div>
        
        <div class="premium-grid premium-grid-3">
            <div class="premium-card premium-scale-in text-center">
                <i class="fas fa-check-circle premium-card-icon"></i>
                <h3 class="premium-card-title">Quality Assurance</h3>
                <p class="premium-card-text">All suppliers undergo rigorous verification processes to ensure product quality and reliability.</p>
            </div>
            <div class="premium-card premium-scale-in text-center">
                <i class="fas fa-bolt premium-card-icon"></i>
                <h3 class="premium-card-title">Fast & Efficient</h3>
                <p class="premium-card-text">Streamlined processes and advanced logistics ensure quick and efficient order fulfillment.</p>
            </div>
            <div class="premium-card premium-scale-in text-center">
                <i class="fas fa-headset premium-card-icon"></i>
                <h3 class="premium-card-title">24/7 Support</h3>
                <p class="premium-card-text">Round-the-clock customer support to assist you with any questions or concerns.</p>
            </div>
        </div>
    </div>
</section>

<!-- Premium CTA Section -->
<section class="premium-section">
    <div class="premium-container">
        <div class="premium-card text-center" style="background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(245, 158, 11, 0.05) 100%);">
            <h2 class="premium-title mb-3">Ready to Get <span class="accent-text">Started</span>?</h2>
            <p class="premium-subtitle mb-4">Join thousands of businesses already trading on Jet Cartridge</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn-premium btn-premium-primary">
                    <i class="fas fa-user-plus me-2"></i>Join as Buyer
                </a>
                <a href="{{ route('seller.register') }}" class="btn-premium btn-premium-secondary">
                    <i class="fas fa-store me-2"></i>Join as Seller
                </a>
                <a href="{{ route('manufacturer.register') }}" class="btn-premium btn-premium-secondary">
                    <i class="fas fa-industry me-2"></i>Join as Manufacturer
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
