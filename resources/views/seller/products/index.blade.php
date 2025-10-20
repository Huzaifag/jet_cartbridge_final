@extends('seller.layouts.app')

@section('content')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckbox = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.row-checkbox');
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                const selectedIdsInput = document.getElementById('selectedIds');

                // Select/Deselect all checkboxes
                if (selectAllCheckbox) {
                    selectAllCheckbox.addEventListener('change', function() {
                        const isChecked = this.checked;
                        checkboxes.forEach(checkbox => {
                            checkbox.checked = isChecked;
                        });
                        updateBulkDeleteButton();
                    });
                }

                // Update select all checkbox when individual checkboxes are clicked
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        if (selectAllCheckbox) {
                            selectAllCheckbox.checked = allChecked;
                        }
                        updateBulkDeleteButton();
                    });
                });

                // Update the bulk delete button state and selected IDs
                function updateBulkDeleteButton() {
                    const selectedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
                    if (selectedCheckboxes.length > 0) {
                        bulkDeleteBtn.style.display = 'inline-block';
                        const selectedIds = Array.from(selectedCheckboxes).map(checkbox => checkbox.value);
                        selectedIdsInput.value = JSON.stringify(selectedIds);
                    } else {
                        bulkDeleteBtn.style.display = 'none';
                        selectedIdsInput.value = '';
                    }
                }

                // Confirm before bulk delete
                const bulkDeleteForm = document.getElementById('bulkDeleteForm');
                if (bulkDeleteForm) {
                    bulkDeleteForm.addEventListener('submit', function(e) {
                        const selectedCount = document.querySelectorAll('.row-checkbox:checked').length;
                        if (!confirm(`Are you sure you want to delete ${selectedCount} selected product(s)?`)) {
                            e.preventDefault();
                        }
                    });
                }
            });
        </script>
    @endpush
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">My Products</h2>
            <div>
                <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
                <a href="{{ route('seller.products.createBulk') }}" class="btn btn-secondary">
                    <i class="fas fa-plus me-2"></i>Add Bulk Products
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="stats-cards">
                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(67, 97, 238, 0.1); color: #4361ee;">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $products->count() }}</div>
                            <div class="stat-title">Total Products</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $products->where('verification_status', 'approved')->count() }}</div>
                            <div class="stat-title">Approved Products</div>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-value">{{ $products->where('verification_status', 'pending')->count() }}</div>
                            <div class="stat-title">Pending Products</div>
                        </div>
                    </div>
                </div>

                <div class="filter-section">
                    <form action="{{ route('seller.products.index') }}" method="GET">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="search-form">
                                    <i class="fas fa-search"></i>
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search products..." value="{{ request('search') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="status">
                                    <option value="">All Status</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="stock_range">
                                    <option value="">All Stock Range</option>
                                    <option value="1-10" {{ request('stock_range') == '1-10' ? 'selected' : '' }}>1-10
                                    </option>
                                    <option value="11-50" {{ request('stock_range') == '11-50' ? 'selected' : '' }}>11-50
                                    </option>
                                    <option value="51-200" {{ request('stock_range') == '51-200' ? 'selected' : '' }}>
                                        51-200</option>
                                    <option value="201-500" {{ request('stock_range') == '201-500' ? 'selected' : '' }}>
                                        201-500</option>
                                    <option value="500+" {{ request('stock_range') == '500+' ? 'selected' : '' }}>500+
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="price_range">
                                    <option value="">All Price Range</option>
                                    <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>0-50
                                    </option>
                                    <option value="51-100" {{ request('price_range') == '51-100' ? 'selected' : '' }}>
                                        51-100</option>
                                    <option value="101-200" {{ request('price_range') == '101-200' ? 'selected' : '' }}>
                                        101-200</option>
                                    <option value="201-500" {{ request('price_range') == '201-500' ? 'selected' : '' }}>
                                        201-500</option>
                                    <option value="501+" {{ request('price_range') == '501+' ? 'selected' : '' }}>501+
                                    </option>
                                </select>
                            </div>

                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Clear Filters
                                </a>
                            </div>
                        </div>

                        @if (request()->has('search') ||
                                request()->has('status') ||
                                request()->has('stock_range') ||
                                request()->has('price_range'))
                            <div class="filter-tags">
                                @if (request('search'))
                                    <div class="filter-tag">
                                        Search: "{{ request('search') }}"
                                        <a href="{{ route('seller.products.index', array_merge(request()->except('search'), ['page' => 1])) }}"
                                            class="close">&times;</a>
                                    </div>
                                @endif

                                @if (request('status'))
                                    <div class="filter-tag">
                                        Status: {{ ucfirst(request('status')) }}
                                        <a href="{{ route('seller.products.index', array_merge(request()->except('status'), ['page' => 1])) }}"
                                            class="close">&times;</a>
                                    </div>
                                @endif

                                @if (request('stock_range'))
                                    <div class="filter-tag">
                                        Stock Range: {{ request('stock_range') }}
                                        <a href="{{ route('seller.products.index', array_merge(request()->except('stock_range'), ['page' => 1])) }}"
                                            class="close">&times;</a>
                                    </div>
                                @endif

                                @if (request('price_range'))
                                    <div class="filter-tag">
                                        Price Range: {{ request('price_range') }}
                                        <a href="{{ route('seller.products.index', array_merge(request()->except('price_range'), ['page' => 1])) }}"
                                            class="close">&times;</a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </form>
                </div>

                @if ($products->count() > 0)
                    {{-- Bulk Delete Form and Button --}}
                    <form id="bulkDeleteForm" action="{{ route('seller.products.bulk-delete') }}" method="POST"
                        class="mb-3">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex align-items-center mb-3">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Select All
                                </label>
                            </div>
                            <input type="hidden" name="selected_ids" id="selectedIds">
                            <button type="submit" id="bulkDeleteBtn" class="btn btn-danger btn-sm"
                                style="display: none;">
                                <i class="fas fa-trash me-2"></i>Delete Selected
                            </button>
                        </div>
                    </form>

                    {{-- Card View for Products --}}
                    <div class="row product-cards-grid">
                        @foreach ($products as $product)
                            <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
                                <div class="card h-100 product-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start">
                                            {{-- Checkbox and ID --}}
                                            <div class="form-check">
                                                <input class="form-check-input row-checkbox" type="checkbox"
                                                    name="selected_products[]" value="{{ $product->id }}">
                                                <label class="form-check-label text-muted"
                                                    for="product-{{ $product->id }}">
                                                    #{{ $product->id }}
                                                </label>
                                            </div>

                                            {{-- Status Badges --}}
                                            <div>
                                                <span
                                                    class="badge bg-{{ $product->status === 'active' ? 'success' : 'warning' }} me-1">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                                <span
                                                    class="badge bg-{{ $product->verification_status === 'approved' ? 'primary' : ($product->verification_status === 'pending' ? 'secondary' : 'danger') }}">
                                                    {{ ucfirst($product->verification_status) }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mt-3 mb-3">
                                            {{-- Image --}}
                                            @php
                                                $images = is_array($product->images)
                                                    ? $product->images
                                                    : json_decode($product->images, true);
                                                $firstImage = $images[0] ?? null;
                                            @endphp

                                            @if ($firstImage)
                                                <img src="{{ asset($firstImage) }}"
                                                    alt="{{ $product->name }}" class="product-img me-3">
                                            @else
                                                <div class="product-img bg-light d-flex align-items-center justify-content-center me-3"
                                                    style="width: 70px; height: 70px;">
                                                    <i class="fas fa-image text-muted fa-2x"></i>
                                                </div>
                                            @endif

                                            {{-- Product Name and Description --}}
                                            <div class="flex-grow-1">
                                                <h5 class="card-title mb-1">{{ $product->name }}</h5>
                                                <p class="card-text text-muted small mb-0">
                                                    {{ Str::limit($product->description, 80) }}</p>
                                            </div>
                                        </div>

                                        {{-- Key Details Grid --}}
                                        <div class="row row-cols-2 g-2 small product-details-grid">
                                            <div class="col"><strong>Category:</strong> {{ $product->category }}</div>
                                            <div class="col"><strong>Brand:</strong> {{ $product->brand }}</div>
                                            <div class="col"><strong>Model:</strong> {{ $product->model }}</div>
                                            <div class="col"><strong>Stock:</strong> <span
                                                    class="fw-bold text-{{ $product->stock_quantity > 10 ? 'success' : 'danger' }}">{{ $product->stock_quantity }}</span>
                                            </div>
                                            <div class="col"><strong>B2C Price:</strong> <span
                                                    class="fw-bold">${{ number_format($product->b2c_price, 2) }}</span>
                                            </div>
                                            <div class="col"><strong>B2C Compare Price:</strong> <span
                                                    class="text-decoration-line-through text-muted">${{ number_format($product->b2c_compare_price, 2) }}</span>
                                            </div>
                                            <div class="col"><strong>B2B Price:</strong> <span
                                                    class="fw-bold text-info">${{ number_format($product->b2b_price, 2) }}</span>
                                            </div>
                                            <div class="col"><strong>B2B MOQ:</strong> {{ $product->b2b_moq }}</div>
                                        </div>

                                        {{-- Actions --}}
                                        <div class="mt-3 text-end action-buttons">
                                            <a href="{{ route('seller.products.edit', $product->id) }}"
                                                class="btn btn-sm btn-info">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                            <form action="{{ route('seller.products.destroy', $product->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4>No Products Found</h4>
                        <p class="text-muted">You haven't added any products yet.</p>
                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- New/Updated CSS for Card View --}}
    <style>
        /* Existing CSS for header/filters/stats... */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }

        .filter-section {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
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

        /* New CSS for Product Cards */
        .product-card {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s;
            border-radius: 12px;
            border: 1px solid #e9ecef;
        }

        .product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        }

        .product-img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #f1f1f1;
            flex-shrink: 0;
        }

        .product-details-grid {
            border-top: 1px dashed #e9ecef;
            padding-top: 1rem;
        }

        .product-details-grid .col {
            padding-bottom: 0.5rem;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #343a40;
        }

        /* Ensure the badge styling remains clean */
        .badge {
            padding: 0.4em 0.7em;
            border-radius: 0.5rem;
            font-weight: 500;
            font-size: 0.75rem;
        }

        /* Responsive adjustments for the card layout */
        /* For large screens, 3 cards per row */
        @media (min-width: 1200px) {
            .product-cards-grid>div {
                flex: 0 0 auto;
                width: 33.33333333%;
            }
        }

        /* For medium screens, 2 cards per row */
        @media (min-width: 768px) and (max-width: 1199px) {
            .product-cards-grid>div {
                flex: 0 0 auto;
                width: 50%;
            }
        }

        /* For small screens, 1 card per row */
        @media (max-width: 767px) {
            .product-cards-grid>div {
                flex: 0 0 auto;
                width: 100%;
            }
        }
    </style>
@endsection
