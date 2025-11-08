@extends('frontend.layout.main')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Resources & Insights</h1>
                <p class="lead text-muted">Knowledge base, guides, and industry insights for B2B success</p>
            </div>
        </div>
    </div>

    <!-- Resource Categories -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <button class="btn btn-outline-primary active filter-btn" data-filter="all">All Resources</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="guides">Buying Guides</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="tips">Business Tips</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="industry">Industry News</button>
                <button class="btn btn-outline-primary filter-btn" data-filter="case-studies">Case Studies</button>
            </div>
        </div>
    </div>

    <!-- Featured Resources -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="h3 mb-4">Featured Resources</h2>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="guides">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="resource-icon me-3">
                            <i class="bi bi-book fs-3 text-primary"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="badge bg-primary mb-2">Buying Guide</span>
                            <h5 class="card-title mb-1">Complete Guide to B2B Procurement</h5>
                            <small class="text-muted">Updated 2 weeks ago</small>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        Learn the essential steps for successful B2B purchasing, from supplier selection
                        to contract negotiation and quality assurance.
                    </p>
                    <a href="#" class="btn btn-primary">Read Guide</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="tips">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="resource-icon me-3">
                            <i class="bi bi-lightbulb fs-3 text-warning"></i>
                        </div>
                        <div class="flex-grow-1">
                            <span class="badge bg-warning text-dark mb-2">Business Tips</span>
                            <h5 class="card-title mb-1">10 Cost-Saving Strategies for Manufacturers</h5>
                            <small class="text-muted">Updated 1 week ago</small>
                        </div>
                    </div>
                    <p class="card-text text-muted">
                        Discover practical strategies to reduce operational costs and improve
                        profit margins in your manufacturing business.
                    </p>
                    <a href="#" class="btn btn-warning">Read Tips</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Resource Grid -->
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="industry">
                <div class="card-body p-4">
                    <div class="resource-icon mb-3">
                        <i class="bi bi-newspaper fs-2 text-info"></i>
                    </div>
                    <span class="badge bg-info mb-2">Industry News</span>
                    <h6 class="card-title">Supply Chain Trends 2024</h6>
                    <p class="card-text text-muted small">
                        Emerging trends shaping the future of global supply chains.
                    </p>
                    <small class="text-muted">5 min read</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="case-studies">
                <div class="card-body p-4">
                    <div class="resource-icon mb-3">
                        <i class="bi bi-graph-up fs-2 text-success"></i>
                    </div>
                    <span class="badge bg-success mb-2">Case Study</span>
                    <h6 class="card-title">How TechCorp Reduced Costs by 30%</h6>
                    <p class="card-text text-muted small">
                        Real-world success story of digital transformation in manufacturing.
                    </p>
                    <small class="text-muted">8 min read</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="guides">
                <div class="card-body p-4">
                    <div class="resource-icon mb-3">
                        <i class="bi bi-shield-check fs-2 text-danger"></i>
                    </div>
                    <span class="badge bg-danger mb-2">Guide</span>
                    <h6 class="card-title">Supplier Verification Checklist</h6>
                    <p class="card-text text-muted small">
                        Essential steps to verify supplier credibility and reliability.
                    </p>
                    <small class="text-muted">6 min read</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="tips">
                <div class="card-body p-4">
                    <div class="resource-icon mb-3">
                        <i class="bi bi-chat-dots fs-2 text-secondary"></i>
                    </div>
                    <span class="badge bg-secondary mb-2">Tips</span>
                    <h6 class="card-title">Effective Negotiation Strategies</h6>
                    <p class="card-text text-muted small">
                        Master the art of B2B negotiation for better deals and partnerships.
                    </p>
                    <small class="text-muted">7 min read</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="industry">
                <div class="card-body p-4">
                    <div class="resource-icon mb-3">
                        <i class="bi bi-bar-chart fs-2 text-primary"></i>
                    </div>
                    <span class="badge bg-primary mb-2">Market Report</span>
                    <h6 class="card-title">Q4 Manufacturing Report</h6>
                    <p class="card-text text-muted small">
                        Quarterly analysis of manufacturing sector performance and outlook.
                    </p>
                    <small class="text-muted">10 min read</small>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6">
            <div class="card h-100 shadow-sm border-0 resource-card" data-category="case-studies">
                <div class="card-body p-4">
                    <div class="resource-icon mb-3">
                        <i class="bi bi-trophy fs-2 text-warning"></i>
                    </div>
                    <span class="badge bg-warning text-dark mb-2">Success Story</span>
                    <h6 class="card-title">From Local to Global: SME Expansion</h6>
                    <p class="card-text text-muted small">
                        How a small manufacturer scaled to international markets.
                    </p>
                    <small class="text-muted">12 min read</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter Signup -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body p-5 text-center">
                    <h3 class="h4 mb-3">Stay Updated with Industry Insights</h3>
                    <p class="mb-4 opacity-75">
                        Subscribe to our newsletter for the latest B2B trends, market insights, and exclusive content.
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form class="d-flex gap-2">
                                <input type="email" class="form-control" placeholder="Enter your email" required>
                                <button type="submit" class="btn btn-light">Subscribe</button>
                            </form>
                        </div>
                    </div>
                    <small class="opacity-75 mt-3 d-block">
                        We respect your privacy. Unsubscribe at any time.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Help Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 text-center">
                    <h3 class="h5 mb-3">Need More Help?</h3>
                    <p class="text-muted mb-4">
                        Can't find what you're looking for? Our support team is here to help.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="{{ route('faq') }}" class="btn btn-outline-primary">Browse FAQ</a>
                        <a href="{{ route('contact') }}" class="btn btn-primary">Contact Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.resource-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    cursor: pointer;
}

.resource-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.resource-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.filter-btn.active {
    background-color: #0d6efd;
    color: white;
}

.opacity-75 {
    opacity: 0.75;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const resourceCards = document.querySelectorAll('.resource-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            const filter = this.dataset.filter;

            resourceCards.forEach(card => {
                if (filter === 'all' || card.dataset.category === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>
@endsection
