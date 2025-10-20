@extends('seller.layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Leads Management</h1>
                <p class="text-muted mb-0">Manage and track your customer inquiries and leads</p>
            </div>
            <div class="d-flex">
                <button class="btn btn-outline-secondary me-2" data-bs-toggle="modal" data-bs-target="#filterModal">
                    <i class="fas fa-filter me-2"></i>Filters
                </button>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-2"></i>Export
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="stats-cards mb-4">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(67, 97, 238, 0.1); color: #4361ee;">
                <i class="fas fa-inbox"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">142</div>
                <div class="stat-title">Total Leads</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">48</div>
                <div class="stat-title">Converted</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">67</div>
                <div class="stat-title">In Progress</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value">27</div>
                <div class="stat-title">Not Interested</div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section mb-4">
        <form action="{{ route('seller.leads') }}" method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="search-form">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" name="search" placeholder="Search leads..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>New</option>
                        <option value="contacted" {{ request('status') == 'contacted' ? 'selected' : '' }}>Contacted</option>
                        <option value="qualified" {{ request('status') == 'qualified' ? 'selected' : '' }}>Qualified</option>
                        <option value="converted" {{ request('status') == 'converted' ? 'selected' : '' }}>Converted</option>
                        <option value="not_interested" {{ request('status') == 'not_interested' ? 'selected' : '' }}>Not Interested</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="product">
                        <option value="">All Products</option>
                        <option value="1" {{ request('product') == '1' ? 'selected' : '' }}>Premium Burger</option>
                        <option value="2" {{ request('product') == '2' ? 'selected' : '' }}>Special Pizza</option>
                        <option value="3" {{ request('product') == '3' ? 'selected' : '' }}>Deluxe Ice Cream</option>
                        <option value="4" {{ request('product') == '4' ? 'selected' : '' }}>Premium Coffee</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Apply
                    </button>
                </div>
            </div>

            <!-- Active filter tags -->
            @if(request()->has('search') || request()->has('status') || request()->has('product'))
            <div class="filter-tags">
                @if(request('search'))
                <div class="filter-tag">
                    Search: "{{ request('search') }}"
                    <a href="{{ route('seller.leads', array_merge(request()->except('search'), ['page' => 1])) }}" class="close">&times;</a>
                </div>
                @endif

                @if(request('status'))
                <div class="filter-tag">
                    Status: {{ ucfirst(str_replace('_', ' ', request('status'))) }}
                    <a href="{{ route('seller.leads', array_merge(request()->except('status'), ['page' => 1])) }}" class="close">&times;</a>
                </div>
                @endif

                @if(request('product'))
                <div class="filter-tag">
                    @php
                        $productName = '';
                        switch(request('product')) {
                            case '1': $productName = 'Premium Burger'; break;
                            case '2': $productName = 'Special Pizza'; break;
                            case '3': $productName = 'Deluxe Ice Cream'; break;
                            case '4': $productName = 'Premium Coffee'; break;
                            default: $productName = 'Unknown Product';
                        }
                    @endphp
                    Product: {{ $productName }}
                    <a href="{{ route('seller.leads', array_merge(request()->except('product'), ['page' => 1])) }}" class="close">&times;</a>
                </div>
                @endif

                <a href="{{ route('seller.leads') }}" class="btn btn-sm btn-outline-secondary ms-auto">
                    <i class="fas fa-times me-1"></i>Clear All
                </a>
            </div>
            @endif
        </form>
    </div>

    <!-- Leads Table -->
    <div class="table-container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Buyer</th>
                        <th>Email</th>
                        <th>Product</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Received</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="avatar" style="background-color: #{{ substr(md5($lead->buyer_name), 0, 6) }};">
                                        {{ strtoupper(substr($lead->buyer_name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <div class="fw-bold">{{ $lead->buyer_name }}</div>
                                    <div class="small text-muted">{{ $lead->buyer_phone ?? 'No phone' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $lead->buyer_email }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <div class="product-thumb">
                                        <i class="fas fa-{{ $lead->product_icon }}"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-2">
                                    <div class="fw-medium">{{ $lead->product_name }}</div>
                                    <div class="small text-muted">${{ number_format($lead->product_price, 2) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="message-preview">
                                {{ Str::limit($lead->message, 60) }}
                                @if(strlen($lead->message) > 60)
                                <a href="#" class="text-primary read-more" data-bs-toggle="modal" data-bs-target="#messageModal" data-message="{{ $lead->message }}">Read more</a>
                                @endif
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-{{ $lead->status_color }}">{{ ucfirst($lead->status) }}</span>
                        </td>
                        <td>
                            <div class="text-muted small">{{ $lead->received_at->diffForHumans() }}</div>
                            <div class="small">{{ $lead->received_at->format('M j, Y') }}</div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button type="button" class="btn btn-sm btn-info view-lead"
                                        data-bs-toggle="modal" data-bs-target="#leadDetailModal"
                                        data-lead="{{ json_encode($lead) }}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i>Edit</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-check me-2"></i>Mark as Contacted</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-check-circle me-2"></i>Mark as Converted</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i>Delete</a></li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-inbox"></i>
                                <h4>No leads found</h4>
                                <p>Try adjusting your search or filter to find what you're looking for.</p>
                                <a href="{{ route('seller.leads') }}" class="btn btn-primary mt-2">
                                    <i class="fas fa-refresh me-2"></i>Reset Filters
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($leads->hasPages())
        <div class="d-flex justify-content-between align-items-center p-3 border-top">
            <div class="text-muted">
                Showing {{ $leads->firstItem() }} to {{ $leads->lastItem() }} of {{ $leads->total() }} entries
            </div>
            <div>
                {{ $leads->links() }}
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Lead Detail Modal -->
<div class="modal fade" id="leadDetailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Lead Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Buyer Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar me-3" id="detail-avatar" style="width: 50px; height: 50px;"></div>
                                    <div>
                                        <h5 id="detail-buyer-name" class="mb-0"></h5>
                                        <p id="detail-buyer-email" class="text-muted mb-0"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">Phone</small>
                                        <p id="detail-buyer-phone" class="mb-0"></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Location</small>
                                        <p id="detail-buyer-location" class="mb-0">Unknown</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Lead Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <small class="text-muted">Status</small>
                                        <p id="detail-status" class="mb-0"></p>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">Received</small>
                                        <p id="detail-received" class="mb-0"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <small class="text-muted">Source</small>
                                        <p id="detail-source" class="mb-0">Website Contact Form</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Product Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="product-thumb-lg">
                                    <i id="detail-product-icon" class="fas fa-hamburger"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 id="detail-product-name" class="mb-1"></h5>
                                <p class="text-muted mb-1" id="detail-product-price"></p>
                                <span class="badge bg-secondary" id="detail-product-category">Food</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Message</h6>
                    </div>
                    <div class="card-body">
                        <p id="detail-message" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">
                    <i class="fas fa-envelope me-2"></i>Send Response
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Message Modal -->
<div class="modal fade" id="messageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Full Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p id="full-message"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    display: flex;
    align-items: center;
}

.stat-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.stat-content {
    flex-grow: 1;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
    color: #2c3e50;
}

.stat-title {
    font-size: 0.9rem;
    color: #7f8c8d;
    font-weight: 500;
}

.table-container {
    background: white;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.table thead th {
    background-color: #f8f9fa;
    border-top: none;
    font-weight: 600;
    color: #495057;
    padding: 1rem;
}

.table tbody td {
    padding: 1rem;
    vertical-align: middle;
}

.badge {
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
    font-weight: 500;
}

.action-buttons .btn {
    padding: 0.35rem 0.5rem;
    margin-right: 0.25rem;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
    font-size: 1rem;
}

.product-thumb {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4361ee;
}

.product-thumb-lg {
    width: 60px;
    height: 60px;
    border-radius: 12px;
    background-color: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #4361ee;
}

.message-preview {
    max-width: 200px;
}

.filter-section {
    background: white;
    border-radius: 10px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.search-form {
    position: relative;
}

.search-form .form-control {
    padding-left: 2.5rem;
    border-radius: 0.5rem;
}

.search-form i {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
}

.filter-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-top: 1rem;
}

.filter-tag {
    background: #e9ecef;
    padding: 0.35rem 0.75rem;
    border-radius: 1rem;
    font-size: 0.85rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.filter-tag .close {
    font-size: 1.25rem;
    line-height: 1;
    cursor: pointer;
}

.empty-state {
    text-align: center;
    padding: 3rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

.page-header {
    padding-bottom: 1rem;
    margin-bottom: 2rem;
    border-bottom: 1px solid #e9ecef;
}

.read-more {
    font-size: 0.875rem;
    text-decoration: none;
}

.read-more:hover {
    text-decoration: underline;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Handle view lead button click
    $('.view-lead').click(function() {
        const lead = JSON.parse($(this).data('lead'));

        // Populate modal with lead data
        $('#detail-avatar')
            .html(lead.buyer_name.charAt(0).toUpperCase())
            .css('background-color', '#' + md5(lead.buyer_name).substring(0, 6));

        $('#detail-buyer-name').text(lead.buyer_name);
        $('#detail-buyer-email').text(lead.buyer_email);
        $('#detail-buyer-phone').text(lead.buyer_phone || 'Not provided');
        $('#detail-status').html(`<span class="badge bg-${lead.status_color}">${lead.status}</span>`);
        $('#detail-received').text(lead.received_at);
        $('#detail-product-icon').attr('class', 'fas fa-' + lead.product_icon);
        $('#detail-product-name').text(lead.product_name);
        $('#detail-product-price').text('$' + lead.product_price.toFixed(2));
        $('#detail-message').text(lead.message);
    });

    // Handle read more message click
    $('.read-more').click(function() {
        const message = $(this).data('message');
        $('#full-message').text(message);
    });

    // Status badge colors based on status
    function getStatusColor(status) {
        switch(status) {
            case 'new': return 'primary';
            case 'contacted': return 'info';
            case 'qualified': return 'warning';
            case 'converted': return 'success';
            case 'not_interested': return 'danger';
            default: return 'secondary';
        }
    }

    // Apply status colors to badges
    $('.badge').each(function() {
        const status = $(this).text().toLowerCase().replace(' ', '_');
        const color = getStatusColor(status);
        $(this).addClass('bg-' + color);
    });
});
</script>
@endpush
@endsection
