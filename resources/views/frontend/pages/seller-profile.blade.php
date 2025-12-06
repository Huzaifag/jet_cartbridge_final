@extends('frontend.layout.main')

@section('title', $seller->company_name . ' - Seller Profile')

@section('content')
    <div class="container py-5">
        <!-- Seller Header (improved with optional banner/logo and cleaner layout) -->
        <div class="card mb-4 shadow-sm border-0">
            <div class="seller-banner position-relative" style="overflow:hidden; border-radius: .5rem;">
                @php
                    $bannerUrl = $seller->banner && \Illuminate\Support\Facades\Storage::disk('public')->exists($seller->banner)
                        ? asset('storage/' . $seller->banner)
                        : null;
                @endphp
                @if($bannerUrl)
                    <img src="{{ $bannerUrl }}" alt="{{ $seller->company_name }} banner" class="w-100" style="height:180px; object-fit:cover; filter:brightness(.75);">
                @else
                    <div style="background: linear-gradient(135deg,#f5f7fa,#eef2f5); height:180px; display:flex; align-items:center; justify-content:center;">
                        <div class="text-center text-muted">
                            <h4 class="mb-0">{{ $seller->company_name }}</h4>
                        </div>
                    </div>
                @endif
                <div class="card-body position-relative" style="margin-top:-60px;">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            @php
                                $logoUrl = $seller->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($seller->logo)
                                    ? asset('storage/' . $seller->logo)
                                    : null;
                            @endphp
                            @if($logoUrl)
                                <img src="{{ $logoUrl }}" alt="{{ $seller->company_name }} logo" class="avatar-circle shadow-sm" style="width:100px; height:100px; object-fit:cover; border-radius:50%; border:4px solid #fff;">
                            @else
                                <div class="avatar-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width:100px; height:100px; font-size:2rem; border-radius:50%; color:#fff;">
                                    {{ strtoupper(substr($seller->company_name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            <h2 class="mb-1">{{ $seller->company_name }}
                                @if($seller->is_verified)
                                    <small class="ms-2 badge bg-success align-top"><i class="fas fa-check-circle"></i> Verified</small>
                                @endif
                            </h2>
                            <p class="text-muted mb-2">
                                <span class="me-3"><i class="fas fa-map-marker-alt me-1"></i> {{ $seller->company_city }}, {{ $seller->company_country }}</span>
                                <span><i class="fas fa-calendar-alt me-1"></i> Member since {{ $seller->created_at->format('M Y') }}</span>
                            </p>
                            <p class="mb-0 text-muted small">{{ $seller->company_profile ?? 'No profile description available.' }}</p>
                        </div>
                        <div class="col-auto text-end">
                            <div class="d-grid gap-2">
                                @auth
                                    <button class="btn btn-primary" onclick="startChat('{{ $seller->id }}')">
                                        <i class="fas fa-comment-dots me-1"></i> Contact Seller
                                    </button>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-1"></i> Login to Contact
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Past Orders Section (Only for logged-in users who have ordered) -->
        @if(auth()->check() && $pastOrders->isNotEmpty())
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h4 class="mb-0"><i class="fas fa-history me-2 text-primary"></i>My Past Orders with
                        {{ $seller->company_name }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pastOrders as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td>{{ $order->created_at->format('d M, Y') }}</td>
                                        <td>
                                            <ul class="list-unstyled mb-0">
                                                @foreach($order->orderItems->take(2) as $item)
                                                    <li><small>{{ $item->product->name }} (x{{ $item->quantity }})</small></li>
                                                @endforeach
                                                @if($order->orderItems->count() > 2)
                                                    <li><small class="text-muted">+{{ $order->orderItems->count() - 2 }} more
                                                            items</small></li>
                                                @endif
                                            </ul>
                                        </td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $order->status == 'completed' ? 'success' : ($order->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-light">View
                                                Details</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <!-- Seller's Products -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Products from {{ $seller->company_name }}</h3>
            <span class="text-muted">{{ $products->total() }} Products found</span>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    @include('frontend.pages.partials.product-card', ['product' => $product, 'showTrendingBadge' => false])
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">
                        <i class="fas fa-box-open fa-3x mb-3"></i>
                        <p>This seller has no active products at the moment.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    </div>

        @push('styles')
            <style>
                .avatar-circle { display:inline-flex; align-items:center; justify-content:center; }
                .seller-banner img { display:block; }
                .product-card { transition: transform .15s ease, box-shadow .15s ease; }
                .product-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
                .product-img { width:100%; height:220px; object-fit:cover; display:block; }
                .product-card .card-overlay { background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.45)); opacity:0; transition:opacity .15s ease; }
                .product-card:hover .card-overlay { opacity:1; }
                .card-overlay .btn { opacity:0.95; }
                /* Premium product-card styles (from partial) */
                .premium-product-card { background: #fff; border-radius: .5rem; padding: 0; overflow: hidden; position: relative; }
                .premium-transition { transition: transform .18s ease, box-shadow .18s ease; }
                .premium-transition:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(12,20,39,0.06); }
                .premium-product-image { width:100%; height:220px; object-fit:cover; display:block; }
                .premium-product-content { padding: 1rem; display:flex; flex-direction:column; height:100%; }
                .premium-product-title { font-size: 1rem; margin:0; line-height:1.2; }
                .product-title-multiline { display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
                .premium-badge { display:inline-block; padding: .25rem .5rem; border-radius: .5rem; font-size: .75rem; }
                .premium-badge-outline { border:1px solid rgba(0,0,0,0.06); padding:.25rem .5rem; border-radius:.5rem; font-size:.75rem; }
                .btn-premium { border-radius: .4rem; }
                .btn-premium-primary { background: linear-gradient(90deg,#0066ff,#0051d4); color:#fff; border:none; }
                .btn-premium-secondary { background:#f6f8fa; color:#333; border:1px solid #e9eef4; }
            </style>
        @endpush

    @push('scripts')
        <script>
            function startChat(sellerId) {
                // Implement chat start logic here or redirect to chat page
                window.location.href = "{{ route('chat.start') }}?seller_id=" + sellerId;
            }
        </script>
    @endpush
@endsection