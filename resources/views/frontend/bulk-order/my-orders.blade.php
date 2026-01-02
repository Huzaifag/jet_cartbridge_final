@extends('frontend.layout.main')

@section('title', 'My Bulk Orders')

@push('styles')
<style>
.orders-container {
    min-height: 100vh;
    background: #f8f9fa;
    padding: 2rem 0;
}

.orders-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    text-align: center;
}

.order-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.order-card:hover {
    transform: translateY(-2px);
}

.order-header {
    background: #f8f9fa;
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.order-number {
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
}

.order-date {
    color: #6c757d;
    font-size: 0.9rem;
}

.order-body {
    padding: 1.5rem;
}

.seller-info {
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
}

.seller-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    margin-right: 1rem;
    object-fit: cover;
}

.seller-details h6 {
    margin: 0;
    color: #2c3e50;
}

.seller-details small {
    color: #6c757d;
}

.order-summary {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #e9ecef;
}

.order-total {
    font-size: 1.3rem;
    font-weight: bold;
    color: #007bff;
}

.order-items {
    color: #6c757d;
    font-size: 0.9rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #dee2e6;
}

.filter-tabs {
    background: white;
    border-radius: 15px;
    padding: 1rem;
    margin-bottom: 2rem;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.filter-tabs .nav-link {
    border-radius: 25px;
    padding: 0.75rem 1.5rem;
    margin: 0 0.25rem;
    border: none;
    color: #6c757d;
    font-weight: 600;
}

.filter-tabs .nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

@media (max-width: 768px) {
    .order-summary {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .seller-info {
        flex-direction: column;
        text-align: center;
    }
    
    .seller-avatar {
        margin-right: 0;
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@section('content')
<div class="orders-container">
    <div class="container">
        <div class="orders-header">
            <h1><i class="fas fa-clipboard-list me-2"></i>My Bulk Orders</h1>
            <p class="mb-0">Track and manage your bulk order requests</p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <ul class="nav nav-pills justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#" data-filter="all">All Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="pending">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="accepted">Accepted</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="processing">Processing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-filter="delivered">Delivered</a>
                </li>
            </ul>
        </div>

        <!-- Orders List -->
        <div class="orders-list">
            @forelse($bulkOrders as $order)
                <div class="order-card" data-status="{{ $order->status }}">
                    <div class="order-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="order-number">{{ $order->order_number }}</div>
                                <div class="order-date">{{ $order->created_at->format('M d, Y \a\t H:i') }}</div>
                            </div>
                            <span class="badge status-badge bg-{{ $order->status_color }}-subtle text-{{ $order->status_color }}">
                                {{ $order->formatted_status }}
                            </span>
                        </div>
                    </div>

                    <div class="order-body">
                        <!-- Seller Information -->
                        <div class="seller-info">
                            <img src="{{ $order->seller->user->avatar ? asset('storage/' . $order->seller->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($order->seller->user->name ?? $order->seller->company_name) . '&background=007bff&color=ffffff&size=50' }}" 
                                 alt="{{ $order->seller->user->name ?? $order->seller->company_name }}" class="seller-avatar">
                            <div class="seller-details">
                                <h6>{{ $order->seller->user->name ?? 'Seller' }}</h6>
                                <small>{{ $order->seller->company_name ?? 'Company' }}</small>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="order-items-preview">
                            <small class="text-muted">Items:</small>
                            @foreach($order->items->take(3) as $item)
                                <span class="badge bg-light text-dark me-1">{{ $item->product->name }} ({{ $item->quantity }})</span>
                            @endforeach
                            @if($order->items->count() > 3)
                                <span class="badge bg-secondary">+{{ $order->items->count() - 3 }} more</span>
                            @endif
                        </div>

                        <!-- Order Summary -->
                        <div class="order-summary">
                            <div>
                                <div class="order-total">${{ number_format($order->total_amount, 2) }}</div>
                                <div class="order-items">{{ $order->total_items }} items</div>
                            </div>
                            <div>
                                <a href="{{ route('bulk-order.show', $order->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>

                        @if($order->delivery_date)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Requested delivery: {{ $order->delivery_date->format('M d, Y') }}
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-shopping-cart"></i>
                    <h4>No Bulk Orders Yet</h4>
                    <p>You haven't placed any bulk orders yet. Start by browsing our sellers and their products.</p>
                    <a href="/bulk-order" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Place Your First Bulk Order
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($bulkOrders->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $bulkOrders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
// Filter functionality
document.querySelectorAll('[data-filter]').forEach(tab => {
    tab.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Update active tab
        document.querySelectorAll('[data-filter]').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        
        const filter = this.dataset.filter;
        const orderCards = document.querySelectorAll('.order-card');
        
        orderCards.forEach(card => {
            if (filter === 'all' || card.dataset.status === filter) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
@endpush