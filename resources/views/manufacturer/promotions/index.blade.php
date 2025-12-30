@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Promotions & Marketing</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Promotions</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotion Statistics -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Active Promotions</p>
                            <h4 class="mb-2">{{ $promotionStats['active_promotions'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +3 this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3">
                                <i class="fas fa-tags font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Usage</p>
                            <h4 class="mb-2">{{ $promotionStats['total_usage'] ?? 0 }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +25% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success-subtle text-success rounded-3">
                                <i class="fas fa-chart-bar font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Total Savings</p>
                            <h4 class="mb-2">${{ number_format($promotionStats['total_savings'] ?? 0, 0) }}</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +18% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3">
                                <i class="fas fa-dollar-sign font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Conversion Rate</p>
                            <h4 class="mb-2">{{ $promotionStats['conversion_rate'] ?? 0 }}%</h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    +2.3% this month
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info-subtle text-info rounded-3">
                                <i class="fas fa-percentage font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search promotions..." id="searchPromotions">
                                    <i class="fas fa-search search-icon"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="expired">Expired</option>
                                <option value="scheduled">Scheduled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" id="filterType">
                                <option value="">All Types</option>
                                <option value="percentage">Percentage</option>
                                <option value="fixed">Fixed Amount</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPromotionModal">
                                    <i class="fas fa-plus me-1"></i> Create Promotion
                                </button>
                                <button type="button" class="btn btn-success" onclick="exportPromotions()">
                                    <i class="fas fa-download me-1"></i> Export
                                </button>
                                <button type="button" class="btn btn-info" onclick="generateCoupon()">
                                    <i class="fas fa-ticket-alt me-1"></i> Generate Coupon
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Promotions Grid -->
    <div class="row" id="promotionsGrid">
        @forelse($promotions ?? [] as $promotion)
            <div class="col-xl-6 col-lg-12 promotion-card" data-status="{{ $promotion['status'] }}" data-type="{{ $promotion['type'] }}">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="flex-1">
                                <h5 class="card-title mb-1">{{ $promotion['title'] }}</h5>
                                <p class="text-muted mb-2">{{ $promotion['description'] }}</p>
                            </div>
                            <div class="dropdown">
                                <a class="text-muted dropdown-toggle font-size-16" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" onclick="viewPromotion({{ $promotion['id'] }})">View Details</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="editPromotion({{ $promotion['id'] }})">Edit</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="duplicatePromotion({{ $promotion['id'] }})">Duplicate</a></li>
                                    @if($promotion['status'] === 'active')
                                        <li><a class="dropdown-item text-warning" href="#" onclick="deactivatePromotion({{ $promotion['id'] }})">Deactivate</a></li>
                                    @else
                                        <li><a class="dropdown-item text-success" href="#" onclick="activatePromotion({{ $promotion['id'] }})">Activate</a></li>
                                    @endif
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="deletePromotion({{ $promotion['id'] }})">Delete</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2">
                                        <span class="avatar-title bg-primary-subtle text-primary rounded">
                                            @if($promotion['type'] === 'percentage')
                                                <i class="fas fa-percentage"></i>
                                            @else
                                                <i class="fas fa-dollar-sign"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0 font-size-12 text-muted">Discount</p>
                                        <h6 class="mb-0">
                                            @if($promotion['type'] === 'percentage')
                                                {{ $promotion['discount_value'] }}%
                                            @else
                                                ${{ number_format($promotion['discount_value'], 2) }}
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2">
                                        <span class="avatar-title bg-success-subtle text-success rounded">
                                            <i class="fas fa-chart-line"></i>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="mb-0 font-size-12 text-muted">Usage</p>
                                        <h6 class="mb-0">{{ $promotion['usage_count'] }}/{{ $promotion['usage_limit'] ?? '∞' }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <p class="mb-1 font-size-12 text-muted">Start Date</p>
                                <p class="mb-0 font-size-13">{{ \Carbon\Carbon::parse($promotion['start_date'])->format('M d, Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1 font-size-12 text-muted">End Date</p>
                                <p class="mb-0 font-size-13">{{ \Carbon\Carbon::parse($promotion['end_date'])->format('M d, Y') }}</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-{{ $promotion['status'] === 'active' ? 'success' : ($promotion['status'] === 'expired' ? 'danger' : 'warning') }}-subtle text-{{ $promotion['status'] === 'active' ? 'success' : ($promotion['status'] === 'expired' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($promotion['status']) }}
                                </span>
                                <span class="badge bg-light text-dark ms-1">{{ ucfirst(str_replace('_', ' ', $promotion['target_audience'])) }}</span>
                            </div>
                            <div class="progress" style="width: 100px; height: 6px;">
                                @php
                                    $usagePercentage = $promotion['usage_limit'] ? ($promotion['usage_count'] / $promotion['usage_limit']) * 100 : 0;
                                @endphp
                                <div class="progress-bar bg-success" style="width: {{ min($usagePercentage, 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No promotions found</h5>
                    <p class="text-muted">Create your first promotion to boost sales and attract customers.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPromotionModal">
                        <i class="fas fa-plus me-1"></i> Create First Promotion
                    </button>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Add Promotion Modal -->
<div class="modal fade" id="addPromotionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Promotion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addPromotionForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Promotion Title *</label>
                                <input type="text" class="form-control" name="title" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Discount Type *</label>
                                <select class="form-select" name="type" required>
                                    <option value="">Select Type</option>
                                    <option value="percentage">Percentage (%)</option>
                                    <option value="fixed">Fixed Amount ($)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea class="form-control" name="description" rows="2" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Discount Value *</label>
                                <input type="number" class="form-control" name="discount_value" min="0" step="0.01" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Min Order Amount</label>
                                <input type="number" class="form-control" name="min_order_amount" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Max Discount</label>
                                <input type="number" class="form-control" name="max_discount" min="0" step="0.01">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Start Date *</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">End Date *</label>
                                <input type="date" class="form-control" name="end_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Usage Limit</label>
                                <input type="number" class="form-control" name="usage_limit" min="1">
                                <small class="text-muted">Leave empty for unlimited usage</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Target Audience *</label>
                                <select class="form-select" name="target_audience" required>
                                    <option value="">Select Audience</option>
                                    <option value="all_customers">All Customers</option>
                                    <option value="new_customers">New Customers</option>
                                    <option value="business_customers">Business Customers</option>
                                    <option value="vip_customers">VIP Customers</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Applicable Products</label>
                        <select class="form-select" name="applicable_products[]" multiple>
                            <option value="Wireless Headphones">Wireless Headphones</option>
                            <option value="Smart Watches">Smart Watches</option>
                            <option value="Bluetooth Speakers">Bluetooth Speakers</option>
                            <option value="Phone Accessories">Phone Accessories</option>
                            <option value="Smart Home Devices">Smart Home Devices</option>
                        </select>
                        <small class="text-muted">Leave empty to apply to all products</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Promotion</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search and filter functionality
document.getElementById('searchPromotions').addEventListener('input', filterPromotions);
document.getElementById('filterStatus').addEventListener('change', filterPromotions);
document.getElementById('filterType').addEventListener('change', filterPromotions);

function filterPromotions() {
    const searchTerm = document.getElementById('searchPromotions').value.toLowerCase();
    const statusFilter = document.getElementById('filterStatus').value;
    const typeFilter = document.getElementById('filterType').value;
    
    const cards = document.querySelectorAll('.promotion-card');
    
    cards.forEach(card => {
        const title = card.querySelector('.card-title').textContent.toLowerCase();
        const description = card.querySelector('.text-muted').textContent.toLowerCase();
        const status = card.dataset.status;
        const type = card.dataset.type;
        
        const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
        const matchesStatus = !statusFilter || status === statusFilter;
        const matchesType = !typeFilter || type === typeFilter;
        
        if (matchesSearch && matchesStatus && matchesType) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Promotion actions
function viewPromotion(id) {
    console.log('View promotion:', id);
    // Implementation for viewing promotion details
}

function editPromotion(id) {
    console.log('Edit promotion:', id);
    // Implementation for editing promotion
}

function duplicatePromotion(id) {
    if (confirm('Are you sure you want to duplicate this promotion?')) {
        console.log('Duplicate promotion:', id);
        // Implementation for duplicating promotion
    }
}

function activatePromotion(id) {
    if (confirm('Are you sure you want to activate this promotion?')) {
        console.log('Activate promotion:', id);
        // Implementation for activating promotion
    }
}

function deactivatePromotion(id) {
    if (confirm('Are you sure you want to deactivate this promotion?')) {
        console.log('Deactivate promotion:', id);
        // Implementation for deactivating promotion
    }
}

function deletePromotion(id) {
    if (confirm('Are you sure you want to delete this promotion?')) {
        console.log('Delete promotion:', id);
        // Implementation for deleting promotion
    }
}

function exportPromotions() {
    console.log('Export promotions');
    // Implementation for exporting promotions
}

function generateCoupon() {
    console.log('Generate coupon');
    // Implementation for generating coupon code
}

// Add promotion form
document.getElementById('addPromotionForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    // Here you would typically send the data to your backend
    console.log('Adding promotion:', Object.fromEntries(formData));
    
    // Close modal and reset form
    const modal = bootstrap.Modal.getInstance(document.getElementById('addPromotionModal'));
    modal.hide();
    this.reset();
    
    // Show success message
    alert('Promotion created successfully!');
});

// Set minimum date for start date to today
document.querySelector('input[name="start_date"]').min = new Date().toISOString().split('T')[0];

// Update end date minimum when start date changes
document.querySelector('input[name="start_date"]').addEventListener('change', function() {
    const endDateInput = document.querySelector('input[name="end_date"]');
    endDateInput.min = this.value;
    if (endDateInput.value && endDateInput.value <= this.value) {
        endDateInput.value = '';
    }
});
</script>
@endpush