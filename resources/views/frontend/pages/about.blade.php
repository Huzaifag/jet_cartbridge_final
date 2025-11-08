@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">About Jet Cartridge</h1>
                <p class="lead text-muted">Connecting businesses worldwide through innovative B2B marketplace solutions</p>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h2 class="h3 mb-4">Our Mission</h2>
                    <p class="mb-4">
                        Jet Cartridge is a premier B2B marketplace platform designed to revolutionize how businesses connect,
                        trade, and grow. We bridge the gap between manufacturers, suppliers, and buyers worldwide,
                        creating seamless trading experiences through cutting-edge technology and trusted partnerships.
                    </p>

                    <h2 class="h3 mb-4">What We Do</h2>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-shop fs-2 text-primary me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Verified Suppliers</h5>
                                    <p class="text-muted mb-0">Connect with pre-verified manufacturers and suppliers globally.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-shield-check fs-2 text-success me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Secure Transactions</h5>
                                    <p class="text-muted mb-0">Protected payment systems and trade assurance programs.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-globe fs-2 text-info me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Global Reach</h5>
                                    <p class="text-muted mb-0">Access international markets and expand your business horizons.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <i class="bi bi-graph-up fs-2 text-warning me-3"></i>
                                </div>
                                <div>
                                    <h5 class="mb-2">Business Intelligence</h5>
                                    <p class="text-muted mb-0">Data-driven insights to optimize your trading decisions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h2 class="h1 mb-4">Why Choose Jet Cartridge?</h2>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body p-4">
                    <i class="bi bi-check-circle-fill fs-1 text-success mb-3"></i>
                    <h5 class="card-title">Quality Assurance</h5>
                    <p class="card-text text-muted">All suppliers undergo rigorous verification processes to ensure product quality and reliability.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body p-4">
                    <i class="bi bi-lightning-fill fs-1 text-warning mb-3"></i>
                    <h5 class="card-title">Fast & Efficient</h5>
                    <p class="card-text text-muted">Streamlined processes and advanced logistics ensure quick and efficient order fulfillment.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border-0 text-center">
                <div class="card-body p-4">
                    <i class="bi bi-headset fs-1 text-primary mb-3"></i>
                    <h5 class="card-title">24/7 Support</h5>
                    <p class="card-text text-muted">Round-the-clock customer support to assist you with any questions or concerns.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 text-center">
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body p-5">
                    <h2 class="h3 mb-3">Ready to Get Started?</h2>
                    <p class="mb-4">Join thousands of businesses already trading on Jet Cartridge</p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Join as Buyer</a>
                        <a href="{{ route('seller.register') }}" class="btn btn-outline-primary btn-lg">Join as Seller</a>
                        <a href="{{ route('manufacturer.register') }}" class="btn btn-outline-primary btn-lg">Join as Manufacturer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
