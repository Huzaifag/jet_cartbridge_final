@extends('frontend.layout.main')

@section('title', ($seller->company_name ?? 'Seller') . ' - Seller Profile')

@section('content')
    <div class="linkedin-profile-container">
        <!-- Cover Photo & Profile Header -->
        <div class="profile-cover-section">
            <div class="cover-photo">
                @php
                    $bannerUrl = ($seller->banner ?? null) && \Illuminate\Support\Facades\Storage::disk('public')->exists($seller->banner)
                        ? asset('storage/' . $seller->banner)
                        : null;
                @endphp
                @if($bannerUrl)
                    <img src="{{ $bannerUrl }}" alt="{{ $seller->company_name ?? 'Seller' }} banner" class="cover-image">
                @else
                    <div class="cover-placeholder">
                        <div class="cover-gradient"></div>
                    </div>
                @endif
            </div>
            
            <div class="container">
                <div class="profile-header-card">
                    <div class="profile-main-info">
                        <div class="profile-avatar-section">
                            @php
                                $logoUrl = ($seller->logo ?? null) && \Illuminate\Support\Facades\Storage::disk('public')->exists($seller->logo)
                                    ? asset('storage/' . $seller->logo)
                                    : null;
                            @endphp
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $seller->company_name ?? 'Seller' }} logo" class="profile-avatar">
                            @else
                                <div class="profile-avatar-placeholder">
                                    {{ strtoupper(substr($seller->company_name ?? 'S', 0, 2)) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="profile-info">
                            <div class="profile-name-section">
                                <h1 class="profile-name">{{ $seller->company_name ?? 'Seller Profile' }}</h1>
                                @if($seller->is_verified ?? false)
                                    <div class="verification-badge">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Verified Seller</span>
                                    </div>
                                @endif
                            </div>
                            
                            <p class="profile-headline">{{ $seller->company_profile ?? 'Professional B2B Supplier & Manufacturer' }}</p>
                            
                            <div class="profile-location-info">
                                <span class="location-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ ($seller->company_city ?? 'City') }}, {{ ($seller->company_country ?? 'Country') }}
                                </span>
                                <span class="location-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    Member since {{ $seller->created_at ? $seller->created_at->format('M Y') : 'N/A' }}
                                </span>
                                <span class="location-item">
                                    <i class="fas fa-box"></i>
                                    {{ $products ? $products->total() : 0 }} Products
                                </span>
                            </div>
                        </div>
                        
                        <div class="profile-actions">
                            @auth
                                <button class="btn-primary-action" onclick="startChat('{{ $seller->id ?? '' }}')">
                                    <i class="fas fa-comment-dots"></i>
                                    Message
                                </button>
                                <button class="btn-secondary-action" onclick="followSeller('{{ $seller->id ?? '' }}')">
                                    <i class="fas fa-plus"></i>
                                    Follow
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary-action">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login to Contact
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container profile-content">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-8">
                    <!-- About Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">About</h2>
                        </div>
                        <div class="section-content">
                            <p class="about-text">
                                {{ $seller->company_profile ?? 'We are a professional B2B supplier committed to providing high-quality products and exceptional service to our customers worldwide. Our team has years of experience in the industry and we pride ourselves on building long-term partnerships with our clients.' }}
                            </p>
                            
                            <div class="company-stats">
                                <div class="stat-item">
                                    <div class="stat-number">{{ $products ? $products->total() : 0 }}</div>
                                    <div class="stat-label">Products</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ isset($pastOrders) ? $pastOrders->count() : 0 }}</div>
                                    <div class="stat-label">Orders Completed</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">4.8</div>
                                    <div class="stat-label">Rating</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number">{{ $seller->created_at ? $seller->created_at->diffInYears(now()) : 0 }}+</div>
                                    <div class="stat-label">Years Experience</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Details Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-building me-2"></i>
                                Company Information
                            </h2>
                        </div>
                        <div class="section-content">
                            <div class="company-details-grid">
                                <div class="detail-card">
                                    <div class="detail-icon">
                                        <i class="fas fa-industry"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="detail-title">Industry</h4>
                                        <p class="detail-value">{{ $seller->industry ?? 'Manufacturing & Trading' }}</p>
                                    </div>
                                </div>
                                
                                <div class="detail-card">
                                    <div class="detail-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="detail-title">Company Size</h4>
                                        <p class="detail-value">{{ $seller->company_size ?? '50-100 employees' }}</p>
                                    </div>
                                </div>
                                
                                <div class="detail-card">
                                    <div class="detail-icon">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="detail-title">Established</h4>
                                        <p class="detail-value">{{ $seller->established_year ?? '2010' }}</p>
                                    </div>
                                </div>
                                
                                <div class="detail-card">
                                    <div class="detail-icon">
                                        <i class="fas fa-globe"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="detail-title">Markets Served</h4>
                                        <p class="detail-value">{{ $seller->markets_served ?? 'Global' }}</p>
                                    </div>
                                </div>
                                
                                <div class="detail-card">
                                    <div class="detail-icon">
                                        <i class="fas fa-dollar-sign"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="detail-title">Annual Revenue</h4>
                                        <p class="detail-value">{{ $seller->annual_revenue ?? '$1M - $5M' }}</p>
                                    </div>
                                </div>
                                
                                <div class="detail-card">
                                    <div class="detail-icon">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="detail-content">
                                        <h4 class="detail-title">Lead Time</h4>
                                        <p class="detail-value">{{ $seller->lead_time ?? '7-15 days' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Experience & Expertise Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-briefcase me-2"></i>
                                Experience & Expertise
                            </h2>
                        </div>
                        <div class="section-content">
                            <div class="experience-timeline">
                                <div class="experience-item">
                                    <div class="experience-year">{{ $seller->created_at ? $seller->created_at->format('Y') : '2020' }} - Present</div>
                                    <div class="experience-content">
                                        <h4 class="experience-title">B2B Marketplace Seller</h4>
                                        <p class="experience-company">{{ $seller->company_name ?? 'Current Company' }}</p>
                                        <p class="experience-description">
                                            {{ $seller->experience_description ?? 'Specialized in providing high-quality industrial products and machinery to businesses worldwide. Built strong relationships with manufacturers and suppliers to ensure competitive pricing and reliable delivery.' }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="experience-item">
                                    <div class="experience-year">{{ $seller->previous_experience_years ?? '2015' }} - {{ $seller->created_at ? $seller->created_at->format('Y') : '2020' }}</div>
                                    <div class="experience-content">
                                        <h4 class="experience-title">{{ $seller->previous_role ?? 'Sales Manager' }}</h4>
                                        <p class="experience-company">{{ $seller->previous_company ?? 'Previous Manufacturing Company' }}</p>
                                        <p class="experience-description">
                                            {{ $seller->previous_experience_description ?? 'Managed key client accounts and developed new business opportunities in the industrial sector. Gained extensive knowledge of manufacturing processes and quality control standards.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Core Competencies -->
                            <div class="competencies-section">
                                <h4 class="competencies-title">Core Competencies</h4>
                                <div class="competencies-grid">
                                    @php
                                        $competencies = $seller->competencies ?? [
                                            'Quality Control', 'Supply Chain Management', 'International Trade',
                                            'Product Sourcing', 'Customer Relations', 'Technical Support',
                                            'Logistics Coordination', 'Market Analysis'
                                        ];
                                        if (is_string($competencies)) {
                                            $competencies = explode(',', $competencies);
                                        }
                                    @endphp
                                    @foreach($competencies as $competency)
                                        <div class="competency-tag">
                                            <i class="fas fa-check-circle"></i>
                                            {{ trim($competency) }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Certifications & Awards Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">
                                <i class="fas fa-award me-2"></i>
                                Certifications & Awards
                            </h2>
                        </div>
                        <div class="section-content">
                            <div class="certifications-grid">
                                @php
                                    $certifications = $seller->certifications ?? [
                                        ['name' => 'ISO 9001:2015 Quality Management', 'year' => '2023', 'issuer' => 'ISO'],
                                        ['name' => 'CE Certification', 'year' => '2022', 'issuer' => 'European Conformity'],
                                        ['name' => 'Export Excellence Award', 'year' => '2023', 'issuer' => 'Trade Association'],
                                        ['name' => 'Supplier of the Year', 'year' => '2022', 'issuer' => 'Industry Council']
                                    ];
                                @endphp
                                @foreach($certifications as $cert)
                                    <div class="certification-card">
                                        <div class="cert-icon">
                                            <i class="fas fa-certificate"></i>
                                        </div>
                                        <div class="cert-content">
                                            <h5 class="cert-name">{{ is_array($cert) ? $cert['name'] : $cert }}</h5>
                                            <p class="cert-issuer">{{ is_array($cert) ? $cert['issuer'] : 'Certified Authority' }}</p>
                                            <span class="cert-year">{{ is_array($cert) ? $cert['year'] : '2023' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Customer Interaction History (Only for logged-in customers) -->
                    @if(auth()->check() && isset($pastOrders) && $pastOrders->isNotEmpty())
                        <div class="profile-section">
                            <div class="section-header">
                                <h2 class="section-title">
                                    <i class="fas fa-handshake me-2"></i>
                                    Our Business History
                                </h2>
                                <p class="section-subtitle">Your past interactions and orders with {{ $seller->company_name ?? 'this seller' }}</p>
                            </div>
                            <div class="section-content">
                                <div class="interaction-summary">
                                    <div class="summary-cards">
                                        <div class="summary-card">
                                            <div class="summary-icon">
                                                <i class="fas fa-shopping-cart"></i>
                                            </div>
                                            <div class="summary-info">
                                                <div class="summary-number">{{ $pastOrders->count() }}</div>
                                                <div class="summary-label">Total Orders</div>
                                            </div>
                                        </div>
                                        <div class="summary-card">
                                            <div class="summary-icon">
                                                <i class="fas fa-dollar-sign"></i>
                                            </div>
                                            <div class="summary-info">
                                                <div class="summary-number">${{ number_format($pastOrders->sum('total'), 0) }}</div>
                                                <div class="summary-label">Total Spent</div>
                                            </div>
                                        </div>
                                        <div class="summary-card">
                                            <div class="summary-icon">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                            <div class="summary-info">
                                                <div class="summary-number">{{ $pastOrders->first() && $pastOrders->first()->created_at ? $pastOrders->first()->created_at->format('M Y') : 'N/A' }}</div>
                                                <div class="summary-label">First Order</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="orders-timeline">
                                    <h4 class="timeline-title">Recent Orders</h4>
                                    @foreach($pastOrders->take(5) as $order)
                                        <div class="timeline-item">
                                            <div class="timeline-marker">
                                                <i class="fas fa-circle"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <div class="order-header">
                                                    <div class="order-info">
                                                        <h5 class="order-title">Order #{{ $order->order_number ?? 'N/A' }}</h5>
                                                        <span class="order-date">{{ $order->created_at ? $order->created_at->format('M d, Y') : 'N/A' }}</span>
                                                    </div>
                                                    <div class="order-status">
                                                        <span class="status-badge status-{{ $order->status ?? 'pending' }}">
                                                            {{ ucfirst($order->status ?? 'Pending') }}
                                                        </span>
                                                        <span class="order-total">${{ number_format($order->total ?? 0, 2) }}</span>
                                                    </div>
                                                </div>
                                                <div class="order-items">
                                                    @if($order->orderItems && $order->orderItems->count() > 0)
                                                        @foreach($order->orderItems->take(3) as $item)
                                                            <div class="order-item">
                                                                <span class="item-name">{{ $item->product->name ?? 'Product' }}</span>
                                                                <span class="item-qty">x{{ $item->quantity ?? 1 }}</span>
                                                            </div>
                                                        @endforeach
                                                        @if($order->orderItems->count() > 3)
                                                            <div class="order-item">
                                                                <span class="item-more">+{{ $order->orderItems->count() - 3 }} more items</span>
                                                            </div>
                                                        @endif
                                                    @else
                                                        <div class="order-item">
                                                            <span class="item-name">No items found</span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="order-actions">
                                                    <a href="#" class="action-link">View Details</a>
                                                    <a href="#" class="action-link">Reorder</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Products Section -->
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">Products & Services</h2>
                            <p class="section-subtitle">{{ $products ? $products->total() : 0 }} products available</p>
                        </div>
                        <div class="section-content">
                            <div class="products-grid">
                                @if($products && $products->count() > 0)
                                    @foreach($products as $product)
                                        <div class="product-card-linkedin">
                                            <div class="product-image">
                                                @php
                                                    $productImage = 'placeholder.jpg';
                                                    if ($product->images && is_array($product->images) && count($product->images) > 0) {
                                                        $productImage = $product->images[0];
                                                    }
                                                @endphp
                                                <img src="{{ asset($productImage) }}" alt="{{ $product->name ?? 'Product' }}">
                                                <div class="product-overlay">
                                                    @if($product->slug)
                                                        <a href="{{ route('product.show', $product->slug) }}" class="view-product-btn">
                                                            <i class="fas fa-eye"></i>
                                                            View Details
                                                        </a>
                                                    @else
                                                        <span class="view-product-btn disabled">
                                                            <i class="fas fa-eye"></i>
                                                            View Details
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="product-info">
                                                <h4 class="product-title">{{ $product->name ?? 'Product Name' }}</h4>
                                                <p class="product-price">${{ number_format($product->b2b_price ?? 0, 2) }}</p>
                                                <div class="product-meta">
                                                    <span class="product-category">{{ $product->category->name ?? 'General' }}</span>
                                                    <span class="product-moq">MOQ: {{ $product->moq ?? 1 }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="no-products">
                                        <i class="fas fa-box-open"></i>
                                        <h4>No Products Available</h4>
                                        <p>This seller hasn't listed any products yet.</p>
                                    </div>
                                @endif
                            </div>
                            
                            @if($products && $products->hasPages())
                                <div class="pagination-wrapper">
                                    <div class="custom-pagination">
                                        {{ $products->links() }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-4">
                    <!-- Contact Information -->
                    <div class="profile-sidebar-section">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">Contact Information</h3>
                        </div>
                        <div class="sidebar-content">
                            <div class="contact-item">
                                <i class="fas fa-building"></i>
                                <div class="contact-info">
                                    <div class="contact-label">Company</div>
                                    <div class="contact-value">{{ $seller->company_name ?? 'N/A' }}</div>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <div class="contact-info">
                                    <div class="contact-label">Location</div>
                                    <div class="contact-value">{{ ($seller->company_city ?? 'City') }}, {{ ($seller->company_country ?? 'Country') }}</div>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <div class="contact-info">
                                    <div class="contact-label">Email</div>
                                    <div class="contact-value">{{ $seller->user->email ?? 'Contact via message' }}</div>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <div class="contact-info">
                                    <div class="contact-label">Phone</div>
                                    <div class="contact-value">{{ $seller->phone ?? 'Contact via message' }}</div>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-globe"></i>
                                <div class="contact-info">
                                    <div class="contact-label">Website</div>
                                    <div class="contact-value">
                                        @if($seller->website ?? null)
                                            <a href="{{ $seller->website }}" target="_blank" class="website-link">
                                                {{ $seller->website }}
                                            </a>
                                        @else
                                            N/A
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="contact-item">
                                <i class="fas fa-calendar-alt"></i>
                                <div class="contact-info">
                                    <div class="contact-label">Member Since</div>
                                    <div class="contact-value">{{ $seller->created_at ? $seller->created_at->format('F Y') : 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Statistics -->
                    <div class="profile-sidebar-section">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">Business Statistics</h3>
                        </div>
                        <div class="sidebar-content">
                            <div class="stat-row">
                                <div class="stat-icon">
                                    <i class="fas fa-box text-primary"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">{{ $products ? $products->total() : 0 }}</div>
                                    <div class="stat-label">Total Products</div>
                                </div>
                            </div>
                            <div class="stat-row">
                                <div class="stat-icon">
                                    <i class="fas fa-shopping-cart text-success"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">{{ isset($pastOrders) ? $pastOrders->count() : 0 }}</div>
                                    <div class="stat-label">Orders Completed</div>
                                </div>
                            </div>
                            <div class="stat-row">
                                <div class="stat-icon">
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">4.8</div>
                                    <div class="stat-label">Average Rating</div>
                                </div>
                            </div>
                            <div class="stat-row">
                                <div class="stat-icon">
                                    <i class="fas fa-clock text-info"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">{{ $seller->response_time ?? '< 2h' }}</div>
                                    <div class="stat-label">Response Time</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Business Highlights -->
                    <div class="profile-sidebar-section">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">Business Highlights</h3>
                        </div>
                        <div class="sidebar-content">
                            <div class="highlight-item">
                                <i class="fas fa-award text-warning"></i>
                                <span>Verified Business</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-shipping-fast text-primary"></i>
                                <span>Fast Shipping</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-headset text-success"></i>
                                <span>24/7 Support</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-shield-alt text-info"></i>
                                <span>Quality Guaranteed</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-certificate text-danger"></i>
                                <span>ISO Certified</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-globe text-secondary"></i>
                                <span>Global Shipping</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment & Shipping -->
                    <div class="profile-sidebar-section">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">Payment & Shipping</h3>
                        </div>
                        <div class="sidebar-content">
                            <div class="payment-methods">
                                <h5 class="payment-title">Accepted Payments</h5>
                                <div class="payment-icons">
                                    <div class="payment-method">
                                        <i class="fab fa-cc-visa"></i>
                                        <span>Visa</span>
                                    </div>
                                    <div class="payment-method">
                                        <i class="fab fa-cc-mastercard"></i>
                                        <span>Mastercard</span>
                                    </div>
                                    <div class="payment-method">
                                        <i class="fas fa-university"></i>
                                        <span>Bank Transfer</span>
                                    </div>
                                    <div class="payment-method">
                                        <i class="fab fa-paypal"></i>
                                        <span>PayPal</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="shipping-info">
                                <h5 class="shipping-title">Shipping Options</h5>
                                <div class="shipping-methods">
                                    <div class="shipping-method">
                                        <i class="fas fa-truck"></i>
                                        <div class="shipping-details">
                                            <span class="shipping-name">Standard Shipping</span>
                                            <span class="shipping-time">7-15 days</span>
                                        </div>
                                    </div>
                                    <div class="shipping-method">
                                        <i class="fas fa-plane"></i>
                                        <div class="shipping-details">
                                            <span class="shipping-name">Express Shipping</span>
                                            <span class="shipping-time">3-7 days</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="profile-sidebar-section">
                        <div class="sidebar-header">
                            <h3 class="sidebar-title">Quick Actions</h3>
                        </div>
                        <div class="sidebar-content">
                            @auth
                                <button class="quick-action-btn" onclick="startChat('{{ $seller->id ?? '' }}')">
                                    <i class="fas fa-comment-dots"></i>
                                    Start Conversation
                                </button>
                                <button class="quick-action-btn" onclick="requestQuote()">
                                    <i class="fas fa-file-invoice-dollar"></i>
                                    Request Quote
                                </button>
                                <button class="quick-action-btn" onclick="scheduleMeeting()">
                                    <i class="fas fa-video"></i>
                                    Schedule Meeting
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="quick-action-btn">
                                    <i class="fas fa-sign-in-alt"></i>
                                    Login to Contact
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        @push('styles')
            <style>
                /* LinkedIn-style Profile Styles */
                .linkedin-profile-container {
                    background-color: #f3f2ef;
                    min-height: 100vh;
                    padding: 0;
                }

                /* Cover Photo Section */
                .profile-cover-section {
                    position: relative;
                    margin-bottom: 24px;
                }

                .cover-photo {
                    height: 200px;
                    overflow: hidden;
                    position: relative;
                }

                .cover-image {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .cover-placeholder {
                    width: 100%;
                    height: 100%;
                    background: linear-gradient(135deg, #0077b5, #004182);
                    position: relative;
                }

                .cover-gradient {
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: linear-gradient(135deg, rgba(0,119,181,0.8), rgba(0,65,130,0.9));
                }

                /* Profile Header Card */
                .profile-header-card {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15), 0 2px 3px rgba(0,0,0,0.2);
                    margin-top: -80px;
                    position: relative;
                    z-index: 10;
                    padding: 24px;
                }

                .profile-main-info {
                    display: flex;
                    align-items: flex-start;
                    gap: 24px;
                }

                .profile-avatar-section {
                    flex-shrink: 0;
                }

                .profile-avatar {
                    width: 152px;
                    height: 152px;
                    border-radius: 50%;
                    border: 4px solid white;
                    object-fit: cover;
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
                }

                .profile-avatar-placeholder {
                    width: 152px;
                    height: 152px;
                    border-radius: 50%;
                    border: 4px solid white;
                    background: linear-gradient(135deg, #0077b5, #004182);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 48px;
                    font-weight: 600;
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
                }

                .profile-info {
                    flex: 1;
                    min-width: 0;
                }

                .profile-name-section {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 8px;
                }

                .profile-name {
                    font-size: 32px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0;
                    line-height: 1.25;
                }

                .verification-badge {
                    display: flex;
                    align-items: center;
                    gap: 4px;
                    background: #0077b5;
                    color: white;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 12px;
                    font-weight: 500;
                }

                .profile-headline {
                    font-size: 20px;
                    color: rgba(0,0,0,0.9);
                    margin: 0 0 8px 0;
                    line-height: 1.25;
                }

                .profile-location-info {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 16px;
                    color: rgba(0,0,0,0.6);
                    font-size: 14px;
                }

                .location-item {
                    display: flex;
                    align-items: center;
                    gap: 4px;
                }

                .profile-actions {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                    flex-shrink: 0;
                }

                .btn-primary-action {
                    background: #0077b5;
                    color: white;
                    border: 1px solid #0077b5;
                    padding: 8px 24px;
                    border-radius: 24px;
                    font-weight: 600;
                    font-size: 16px;
                    cursor: pointer;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    justify-content: center;
                    transition: all 0.2s ease;
                }

                .btn-primary-action:hover {
                    background: #004182;
                    border-color: #004182;
                    color: white;
                }

                .btn-secondary-action {
                    background: transparent;
                    color: #0077b5;
                    border: 1px solid #0077b5;
                    padding: 8px 24px;
                    border-radius: 24px;
                    font-weight: 600;
                    font-size: 16px;
                    cursor: pointer;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    justify-content: center;
                    transition: all 0.2s ease;
                }

                .btn-secondary-action:hover {
                    background: rgba(0,119,181,0.1);
                    color: #0077b5;
                }

                /* Profile Content */
                .profile-content {
                    padding: 0 24px 24px;
                }

                .profile-section {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15), 0 2px 3px rgba(0,0,0,0.2);
                    margin-bottom: 24px;
                    overflow: hidden;
                }

                .section-header {
                    padding: 24px 24px 0;
                }

                .section-title {
                    font-size: 20px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0 0 4px 0;
                }

                .section-subtitle {
                    color: rgba(0,0,0,0.6);
                    font-size: 14px;
                    margin: 0;
                }

                .section-content {
                    padding: 16px 24px 24px;
                }

                /* About Section */
                .about-text {
                    font-size: 14px;
                    line-height: 1.5;
                    color: rgba(0,0,0,0.9);
                    margin-bottom: 24px;
                }

                .company-stats {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
                    gap: 24px;
                }

                .stat-item {
                    text-align: center;
                }

                .stat-number {
                    font-size: 32px;
                    font-weight: 600;
                    color: #0077b5;
                    line-height: 1;
                }

                .stat-label {
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-top: 4px;
                }

                /* Interaction History */
                .interaction-summary {
                    margin-bottom: 32px;
                }

                .summary-cards {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                    gap: 16px;
                }

                .summary-card {
                    background: #f8f9fa;
                    border-radius: 8px;
                    padding: 20px;
                    display: flex;
                    align-items: center;
                    gap: 16px;
                }

                .summary-icon {
                    width: 48px;
                    height: 48px;
                    background: #0077b5;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 20px;
                }

                .summary-number {
                    font-size: 24px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    line-height: 1;
                }

                .summary-label {
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                }

                /* Orders Timeline */
                .timeline-title {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin-bottom: 20px;
                }

                .timeline-item {
                    display: flex;
                    gap: 16px;
                    margin-bottom: 24px;
                    position: relative;
                }

                .timeline-item:not(:last-child)::after {
                    content: '';
                    position: absolute;
                    left: 11px;
                    top: 32px;
                    bottom: -24px;
                    width: 2px;
                    background: #e9ecef;
                }

                .timeline-marker {
                    flex-shrink: 0;
                    width: 24px;
                    height: 24px;
                    background: white;
                    border: 2px solid #0077b5;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    margin-top: 4px;
                }

                .timeline-marker i {
                    font-size: 8px;
                    color: #0077b5;
                }

                .timeline-content {
                    flex: 1;
                    background: #f8f9fa;
                    border-radius: 8px;
                    padding: 16px;
                }

                .order-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 12px;
                }

                .order-title {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0;
                }

                .order-date {
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                }

                .order-status {
                    text-align: right;
                }

                .status-badge {
                    display: inline-block;
                    padding: 4px 8px;
                    border-radius: 4px;
                    font-size: 11px;
                    font-weight: 600;
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-bottom: 4px;
                }

                .status-completed { background: #d4edda; color: #155724; }
                .status-pending { background: #fff3cd; color: #856404; }
                .status-cancelled { background: #f8d7da; color: #721c24; }

                .order-total {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                }

                .order-items {
                    margin-bottom: 12px;
                }

                .order-item {
                    display: flex;
                    justify-content: space-between;
                    font-size: 14px;
                    color: rgba(0,0,0,0.7);
                    margin-bottom: 4px;
                }

                .item-more {
                    font-style: italic;
                    color: rgba(0,0,0,0.5);
                }

                .order-actions {
                    display: flex;
                    gap: 16px;
                }

                .action-link {
                    color: #0077b5;
                    text-decoration: none;
                    font-size: 14px;
                    font-weight: 500;
                }

                .action-link:hover {
                    text-decoration: underline;
                    color: #004182;
                }

                /* Products Grid */
                .products-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                    gap: 20px;
                }

                .product-card-linkedin {
                    background: white;
                    border-radius: 8px;
                    overflow: hidden;
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15);
                    transition: all 0.2s ease;
                }

                .product-card-linkedin:hover {
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15), 0 4px 8px rgba(0,0,0,0.15);
                    transform: translateY(-2px);
                }

                .product-image {
                    position: relative;
                    height: 200px;
                    overflow: hidden;
                }

                .product-image img {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }

                .product-overlay {
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: rgba(0,0,0,0.7);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    opacity: 0;
                    transition: opacity 0.2s ease;
                }

                .product-card-linkedin:hover .product-overlay {
                    opacity: 1;
                }

                .view-product-btn {
                    background: #0077b5;
                    color: white;
                    padding: 8px 16px;
                    border-radius: 4px;
                    text-decoration: none;
                    font-weight: 500;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                .view-product-btn.disabled {
                    background: #6c757d;
                    cursor: not-allowed;
                    opacity: 0.6;
                }

                .product-info {
                    padding: 16px;
                }

                .product-title {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0 0 8px 0;
                    line-height: 1.3;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                }

                .product-price {
                    font-size: 18px;
                    font-weight: 600;
                    color: #0077b5;
                    margin: 0 0 8px 0;
                }

                .product-meta {
                    display: flex;
                    justify-content: space-between;
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                }

                .no-products {
                    grid-column: 1 / -1;
                    text-align: center;
                    padding: 60px 20px;
                    color: rgba(0,0,0,0.6);
                }

                .no-products i {
                    font-size: 48px;
                    margin-bottom: 16px;
                    color: rgba(0,0,0,0.3);
                }

                /* Pagination Styling */
                .pagination-wrapper {
                    margin-top: 32px;
                    display: flex;
                    justify-content: center;
                }

                .custom-pagination {
                    display: flex;
                    justify-content: center;
                }

                .custom-pagination .pagination {
                    display: flex;
                    gap: 4px;
                    margin: 0;
                    padding: 0;
                    list-style: none;
                    border: none;
                }

                .custom-pagination .page-item {
                    display: flex;
                    margin: 0;
                }

                .custom-pagination .page-link {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    min-width: 40px;
                    height: 40px;
                    padding: 0;
                    background: white;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    color: #0077b5;
                    text-decoration: none;
                    font-weight: 500;
                    font-size: 14px;
                    transition: all 0.2s ease;
                    position: relative;
                }

                .custom-pagination .page-link:hover {
                    background: #f8f9fa;
                    border-color: #0077b5;
                    color: #0077b5;
                    text-decoration: none;
                }

                .custom-pagination .page-link:focus {
                    box-shadow: 0 0 0 0.2rem rgba(0, 119, 181, 0.25);
                    border-color: #0077b5;
                }

                .custom-pagination .page-item.active .page-link {
                    background: #0077b5;
                    border-color: #0077b5;
                    color: white;
                }

                .custom-pagination .page-item.disabled .page-link {
                    background: #f8f9fa;
                    border-color: #e9ecef;
                    color: #6c757d;
                    cursor: not-allowed;
                    opacity: 0.6;
                }

                /* Style navigation arrows specifically */
                .custom-pagination .page-item:first-child .page-link,
                .custom-pagination .page-item:last-child .page-link {
                    font-size: 0;
                    overflow: hidden;
                }

                .custom-pagination .page-item:first-child .page-link::before {
                    content: "‹";
                    font-size: 16px;
                    font-weight: bold;
                    line-height: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 100%;
                }

                .custom-pagination .page-item:last-child .page-link::before {
                    content: "›";
                    font-size: 16px;
                    font-weight: bold;
                    line-height: 1;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    height: 100%;
                }

                /* Hide the default text content in navigation links */
                .custom-pagination .page-item:first-child .page-link span,
                .custom-pagination .page-item:last-child .page-link span {
                    display: none;
                }

                /* Ensure number pages display correctly */
                .custom-pagination .page-item:not(:first-child):not(:last-child) .page-link {
                    font-size: 14px;
                }

                /* Handle ellipsis (...) styling */
                .custom-pagination .page-item .page-link[aria-disabled="true"] {
                    background: transparent;
                    border: none;
                    color: #6c757d;
                    cursor: default;
                }

                .custom-pagination .page-item .page-link[aria-disabled="true"]:hover {
                    background: transparent;
                    border: none;
                    color: #6c757d;
                }

                /* Override any default Bootstrap pagination styles */
                .custom-pagination .pagination .page-link {
                    border-radius: 8px !important;
                    margin: 0 2px;
                }

                .custom-pagination .pagination .page-item:first-child .page-link {
                    border-top-left-radius: 8px !important;
                    border-bottom-left-radius: 8px !important;
                }

                .custom-pagination .pagination .page-item:last-child .page-link {
                    border-top-right-radius: 8px !important;
                    border-bottom-right-radius: 8px !important;
                }

                /* Ensure proper spacing between pagination items */
                .custom-pagination .pagination .page-item + .page-item {
                    margin-left: 0;
                }

                /* Fix for Laravel's default pagination text */
                .custom-pagination .page-link svg {
                    display: none;
                }

                .custom-pagination .page-link .sr-only {
                    display: none;
                }

                /* Company Details Grid */
                .company-details-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap: 20px;
                }

                .detail-card {
                    background: #f8f9fa;
                    border-radius: 12px;
                    padding: 20px;
                    display: flex;
                    align-items: flex-start;
                    gap: 16px;
                    transition: all 0.2s ease;
                }

                .detail-card:hover {
                    background: #e9ecef;
                    transform: translateY(-2px);
                }

                .detail-icon {
                    width: 48px;
                    height: 48px;
                    background: #0077b5;
                    border-radius: 12px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 20px;
                    flex-shrink: 0;
                }

                .detail-content {
                    flex: 1;
                }

                .detail-title {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0 0 4px 0;
                }

                .detail-value {
                    font-size: 14px;
                    color: rgba(0,0,0,0.7);
                    margin: 0;
                }

                /* Experience Timeline */
                .experience-timeline {
                    margin-bottom: 32px;
                }

                .experience-item {
                    display: flex;
                    gap: 24px;
                    margin-bottom: 32px;
                    position: relative;
                }

                .experience-item:not(:last-child)::after {
                    content: '';
                    position: absolute;
                    left: 60px;
                    top: 60px;
                    bottom: -32px;
                    width: 2px;
                    background: #e9ecef;
                }

                .experience-year {
                    flex-shrink: 0;
                    width: 120px;
                    font-size: 14px;
                    font-weight: 600;
                    color: #0077b5;
                    position: relative;
                }

                .experience-year::before {
                    content: '';
                    position: absolute;
                    right: -14px;
                    top: 6px;
                    width: 12px;
                    height: 12px;
                    background: #0077b5;
                    border-radius: 50%;
                    border: 3px solid white;
                    box-shadow: 0 0 0 2px #0077b5;
                }

                .experience-content {
                    flex: 1;
                }

                .experience-title {
                    font-size: 18px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0 0 4px 0;
                }

                .experience-company {
                    font-size: 14px;
                    color: #0077b5;
                    font-weight: 500;
                    margin: 0 0 8px 0;
                }

                .experience-description {
                    font-size: 14px;
                    color: rgba(0,0,0,0.7);
                    line-height: 1.5;
                    margin: 0;
                }

                /* Competencies */
                .competencies-section {
                    margin-top: 32px;
                    padding-top: 32px;
                    border-top: 1px solid #e9ecef;
                }

                .competencies-title {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin-bottom: 16px;
                }

                .competencies-grid {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 12px;
                }

                .competency-tag {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    background: #e3f2fd;
                    color: #0077b5;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-size: 14px;
                    font-weight: 500;
                }

                .competency-tag i {
                    font-size: 12px;
                }

                /* Certifications Grid */
                .certifications-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 16px;
                }

                .certification-card {
                    background: #f8f9fa;
                    border-radius: 12px;
                    padding: 20px;
                    display: flex;
                    align-items: flex-start;
                    gap: 16px;
                    transition: all 0.2s ease;
                }

                .certification-card:hover {
                    background: #e9ecef;
                    transform: translateY(-2px);
                }

                .cert-icon {
                    width: 40px;
                    height: 40px;
                    background: linear-gradient(135deg, #ffd700, #ffb300);
                    border-radius: 8px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: white;
                    font-size: 16px;
                    flex-shrink: 0;
                }

                .cert-content {
                    flex: 1;
                }

                .cert-name {
                    font-size: 14px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0 0 4px 0;
                    line-height: 1.3;
                }

                .cert-issuer {
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                    margin: 0 0 4px 0;
                }

                .cert-year {
                    font-size: 12px;
                    color: #0077b5;
                    font-weight: 500;
                }

                /* Enhanced Sidebar Styles */
                .stat-row {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 16px;
                    padding: 12px;
                    background: #f8f9fa;
                    border-radius: 8px;
                }

                .stat-row:last-child {
                    margin-bottom: 0;
                }

                .stat-icon {
                    width: 36px;
                    height: 36px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 8px;
                    background: rgba(0,119,181,0.1);
                }

                .stat-info {
                    flex: 1;
                }

                .stat-row .stat-number {
                    font-size: 18px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    line-height: 1;
                }

                .stat-row .stat-label {
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                    margin-top: 2px;
                }

                .website-link {
                    color: #0077b5;
                    text-decoration: none;
                    font-size: 12px;
                }

                .website-link:hover {
                    text-decoration: underline;
                }

                /* Payment & Shipping Styles */
                .payment-methods,
                .shipping-info {
                    margin-bottom: 24px;
                }

                .payment-methods:last-child,
                .shipping-info:last-child {
                    margin-bottom: 0;
                }

                .payment-title,
                .shipping-title {
                    font-size: 14px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin-bottom: 12px;
                }

                .payment-icons {
                    display: grid;
                    grid-template-columns: repeat(2, 1fr);
                    gap: 8px;
                }

                .payment-method {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    padding: 8px;
                    background: #f8f9fa;
                    border-radius: 6px;
                    font-size: 12px;
                    color: rgba(0,0,0,0.7);
                }

                .payment-method i {
                    font-size: 16px;
                    color: #0077b5;
                }

                .shipping-methods {
                    display: flex;
                    flex-direction: column;
                    gap: 8px;
                }

                .shipping-method {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 12px;
                    background: #f8f9fa;
                    border-radius: 8px;
                }

                .shipping-method i {
                    font-size: 16px;
                    color: #0077b5;
                }

                .shipping-details {
                    display: flex;
                    flex-direction: column;
                    gap: 2px;
                }

                .shipping-name {
                    font-size: 12px;
                    font-weight: 500;
                    color: rgba(0,0,0,0.9);
                }

                .shipping-time {
                    font-size: 11px;
                    color: rgba(0,0,0,0.6);
                }
                .profile-sidebar-section {
                    background: white;
                    border-radius: 8px;
                    box-shadow: 0 0 0 1px rgba(0,0,0,0.15), 0 2px 3px rgba(0,0,0,0.2);
                    margin-bottom: 24px;
                    overflow: hidden;
                }

                .sidebar-header {
                    padding: 20px 20px 0;
                }

                .sidebar-title {
                    font-size: 16px;
                    font-weight: 600;
                    color: rgba(0,0,0,0.9);
                    margin: 0;
                }

                .sidebar-content {
                    padding: 16px 20px 20px;
                }

                .contact-item {
                    display: flex;
                    align-items: flex-start;
                    gap: 12px;
                    margin-bottom: 16px;
                }

                .contact-item:last-child {
                    margin-bottom: 0;
                }

                .contact-item i {
                    width: 20px;
                    color: rgba(0,0,0,0.6);
                    margin-top: 2px;
                }

                .contact-info {
                    flex: 1;
                }

                .contact-label {
                    font-size: 12px;
                    color: rgba(0,0,0,0.6);
                    text-transform: uppercase;
                    letter-spacing: 0.5px;
                    margin-bottom: 2px;
                }

                .contact-value {
                    font-size: 14px;
                    color: rgba(0,0,0,0.9);
                    font-weight: 500;
                }

                .highlight-item {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    margin-bottom: 12px;
                    font-size: 14px;
                    color: rgba(0,0,0,0.9);
                }

                .highlight-item:last-child {
                    margin-bottom: 0;
                }

                .quick-action-btn {
                    width: 100%;
                    background: transparent;
                    color: #0077b5;
                    border: 1px solid #0077b5;
                    padding: 12px 16px;
                    border-radius: 4px;
                    font-weight: 500;
                    cursor: pointer;
                    text-decoration: none;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    justify-content: center;
                    margin-bottom: 8px;
                    transition: all 0.2s ease;
                }

                .quick-action-btn:hover {
                    background: rgba(0,119,181,0.1);
                    color: #0077b5;
                }

                .quick-action-btn:last-child {
                    margin-bottom: 0;
                }

                /* Responsive Design */
                @media (max-width: 768px) {
                    .profile-main-info {
                        flex-direction: column;
                        text-align: center;
                    }

                    .profile-actions {
                        flex-direction: row;
                        justify-content: center;
                    }

                    .profile-location-info {
                        justify-content: center;
                    }

                    .company-stats {
                        grid-template-columns: repeat(2, 1fr);
                    }

                    .summary-cards {
                        grid-template-columns: 1fr;
                    }

                    .products-grid {
                        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                    }

                    .order-header {
                        flex-direction: column;
                        gap: 8px;
                    }

                    .order-status {
                        text-align: left;
                    }

                    .company-details-grid {
                        grid-template-columns: 1fr;
                    }

                    .experience-item {
                        flex-direction: column;
                        gap: 12px;
                    }

                    .experience-item::after {
                        display: none;
                    }

                    .experience-year {
                        width: auto;
                    }

                    .experience-year::before {
                        display: none;
                    }

                    .certifications-grid {
                        grid-template-columns: 1fr;
                    }

                    .competencies-grid {
                        justify-content: center;
                    }

                    .payment-icons {
                        grid-template-columns: 1fr;
                    }
                }

                @media (max-width: 576px) {
                    .profile-content {
                        padding: 0 16px 16px;
                    }

                    .profile-header-card {
                        margin: -60px 16px 0;
                        padding: 20px;
                    }

                    .profile-avatar,
                    .profile-avatar-placeholder {
                        width: 120px;
                        height: 120px;
                    }

                    .profile-name {
                        font-size: 24px;
                    }

                    .profile-headline {
                        font-size: 16px;
                    }

                    .products-grid {
                        grid-template-columns: 1fr;
                    }

                    .company-stats {
                        grid-template-columns: 1fr;
                    }

                    .detail-card {
                        flex-direction: column;
                        text-align: center;
                        gap: 12px;
                    }

                    .custom-pagination .page-link {
                        min-width: 36px;
                        height: 36px;
                        font-size: 12px;
                    }

                    .custom-pagination .page-item:first-child .page-link::before,
                    .custom-pagination .page-item:last-child .page-link::before {
                        font-size: 14px;
                    }

                    .custom-pagination .page-item:not(:first-child):not(:last-child) .page-link {
                        font-size: 12px;
                    }
                }
            </style>
        @endpush

    @push('scripts')
        <script>
            function startChat(sellerId) {
                // Implement chat start logic here or redirect to chat page
                window.location.href = "{{ route('chat.start') }}?seller_id=" + sellerId;
            }

            function followSeller(sellerId) {
                // Implement follow seller functionality
                fetch('/api/sellers/' + sellerId + '/follow', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button text or show success message
                        alert('Successfully followed seller!');
                    } else {
                        alert('Failed to follow seller. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
            }

            function requestQuote() {
                // Implement quote request functionality
                const sellerId = '{{ $seller->id ?? '' }}';
                if (sellerId) {
                    window.location.href = '/request-quote?seller_id=' + sellerId;
                } else {
                    alert('Seller information not available');
                }
            }

            function scheduleMeeting() {
                // Implement meeting scheduling functionality
                const sellerId = '{{ $seller->id ?? '' }}';
                if (sellerId) {
                    window.location.href = '/schedule-meeting?seller_id=' + sellerId;
                } else {
                    alert('Seller information not available');
                }
            }

            // Smooth scrolling for internal links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Add loading states to action buttons
            document.querySelectorAll('.btn-primary-action, .btn-secondary-action, .quick-action-btn').forEach(button => {
                button.addEventListener('click', function() {
                    if (this.onclick || this.href) {
                        const originalText = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                        this.disabled = true;
                        
                        // Re-enable after 3 seconds if still disabled
                        setTimeout(() => {
                            if (this.disabled) {
                                this.innerHTML = originalText;
                                this.disabled = false;
                            }
                        }, 3000);
                    }
                });
            });

            // Lazy loading for product images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }

            // Add animation on scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Observe profile sections for animation
            document.querySelectorAll('.profile-section, .profile-sidebar-section').forEach(section => {
                section.style.opacity = '0';
                section.style.transform = 'translateY(20px)';
                section.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(section);
            });
        </script>
    @endpush
@endsection