@extends('seller.layouts.app')

@section('content')
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAllCheckboxes = document.querySelectorAll('#selectAll');
                const checkboxes = document.querySelectorAll('.row-checkbox');
                const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
                const selectedIdsInput = document.getElementById('selectedIds');

                // Select/Deselect all checkboxes (handle both header checkboxes)
                selectAllCheckboxes.forEach(selectAllCheckbox => {
                    if (selectAllCheckbox) {
                        selectAllCheckbox.addEventListener('change', function() {
                            const isChecked = this.checked;
                            checkboxes.forEach(checkbox => {
                                checkbox.checked = isChecked;
                            });
                            // Sync both "select all" checkboxes
                            selectAllCheckboxes.forEach(cb => {
                                cb.checked = isChecked;
                            });
                            updateBulkDeleteButton();
                        });
                    }
                });

                // Update select all checkbox when individual checkboxes are clicked
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                        const someChecked = Array.from(checkboxes).some(cb => cb.checked);
                        
                        selectAllCheckboxes.forEach(selectAllCheckbox => {
                            if (selectAllCheckbox) {
                                selectAllCheckbox.checked = allChecked;
                                selectAllCheckbox.indeterminate = someChecked && !allChecked;
                            }
                        });
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
        <div class="page-header mb-4">
            <h2 class="mb-0">My Products</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Product
                </a>
                <a href="{{ route('seller.products.createBulk') }}" class="btn btn-secondary">
                    <i class="fas fa-upload me-2"></i>Bulk Upload
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

        {{-- Statistics Cards --}}
        <div class="stats-cards mb-4">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(67, 97, 238, 0.1); color: #4361ee;">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $products->total() }}</div>
                    <div class="stat-title">Total Products</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(40, 167, 69, 0.1); color: #28a745;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $products->getCollection()->where('verification_status', 'approved')->count() }}</div>
                    <div class="stat-title">Approved Products</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background-color: rgba(255, 193, 7, 0.1); color: #ffc107;">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $products->getCollection()->where('verification_status', 'pending')->count() }}</div>
                    <div class="stat-title">Pending Products</div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Filter Section --}}
                <div class="filter-section mb-4">
                    <form action="{{ route('seller.products.index') }}" method="GET">
                        <div class="row g-3">
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
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="stock_range">
                                    <option value="">All Stock Range</option>
                                    <option value="1-10" {{ request('stock_range') == '1-10' ? 'selected' : '' }}>1-10</option>
                                    <option value="11-50" {{ request('stock_range') == '11-50' ? 'selected' : '' }}>11-50</option>
                                    <option value="51-200" {{ request('stock_range') == '51-200' ? 'selected' : '' }}>51-200</option>
                                    <option value="201-500" {{ request('stock_range') == '201-500' ? 'selected' : '' }}>201-500</option>
                                    <option value="500+" {{ request('stock_range') == '500+' ? 'selected' : '' }}>500+</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select" name="price_range">
                                    <option value="">All Price Range</option>
                                    <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>$0-$50</option>
                                    <option value="51-100" {{ request('price_range') == '51-100' ? 'selected' : '' }}>$51-$100</option>
                                    <option value="101-200" {{ request('price_range') == '101-200' ? 'selected' : '' }}>$101-$200</option>
                                    <option value="201-500" {{ request('price_range') == '201-500' ? 'selected' : '' }}>$201-$500</option>
                                    <option value="501+" {{ request('price_range') == '501+' ? 'selected' : '' }}>$501+</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter me-2"></i>Apply Filters
                                </button>
                                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Clear Filters
                                </a>
                            </div>
                        </div>

                        @if (request()->hasAny(['search', 'status', 'stock_range', 'price_range']))
                            <div class="filter-tags mt-3">
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
                                        Stock: {{ request('stock_range') }}
                                        <a href="{{ route('seller.products.index', array_merge(request()->except('stock_range'), ['page' => 1])) }}"
                                            class="close">&times;</a>
                                    </div>
                                @endif

                                @if (request('price_range'))
                                    <div class="filter-tag">
                                        Price: ${{ request('price_range') }}
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
                    <form id="bulkDeleteForm" action="{{ route('seller.products.bulk-delete') }}" method="POST" class="mb-3">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex align-items-center gap-3">
                            <input type="hidden" name="selected_ids" id="selectedIds">
                            <button type="submit" id="bulkDeleteBtn" class="btn btn-danger btn-sm" style="display: none;">
                                <i class="fas fa-trash me-2"></i>Delete Selected
                            </button>
                        </div>
                    </form>

                    {{-- Products Table --}}
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll">
                                        </div>
                                    </th>
                                    <th style="min-width: 300px;">Product</th>
                                    <th style="min-width: 150px;">Category / Brand</th>
                                    <th style="min-width: 100px;">Stock</th>
                                    <th style="min-width: 180px;">Price</th>
                                    <th style="min-width: 120px;">Status</th>
                                    <th style="min-width: 120px;" class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input row-checkbox" type="checkbox" 
                                                    name="selected_products[]" value="{{ $product->id }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $images = null;
                                                    if (is_string($product->images)) {
                                                        $images = json_decode($product->images, true);
                                                    } elseif (is_array($product->images)) {
                                                        $images = $product->images;
                                                    }
                                                    $firstImage = $images[0] ?? null;
                                                    
                                                    // Fix image path
                                                    if ($firstImage) {
                                                        // Remove 'public/' prefix if exists
                                                        $firstImage = str_replace('public/', '', $firstImage);
                                                        // Use storage path
                                                        $imagePath = Storage::url($firstImage);
                                                    }
                                                @endphp

                                                <div class="product-list-img me-3">
                                                    @if ($firstImage)
                                                        <img src="{{ asset($firstImage) }}" alt="{{ $product->name }}"
                                                            onerror="this.onerror=null; this.parentElement.innerHTML='<i class=\'fas fa-image text-muted\'></i>';">
                                                    @else
                                                        <div class="d-flex align-items-center justify-content-center h-100">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="fw-bold text-dark">{{ $product->name }}</div>
                                                    <div class="text-muted small mt-1">
                                                        {{ Str::limit($product->description, 60) }}
                                                    </div>
                                                    <div class="text-muted small mt-1">
                                                        <span class="badge bg-light text-dark">#{{ $product->id }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            
                                            <div class="fw-semibold">{{ $product->getCategory()->name ?? 'N/A' }}</div>
                                            <div class="text-muted small mt-1">{{ $product->brand ?? 'No Brand' }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="fw-bold text-{{ $product->stock_quantity > 10 ? 'success' : 'danger' }}">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                                @if ($product->stock_quantity <= 10)
                                                    <span class="badge bg-warning text-dark">Low</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="mb-1">
                                                <span class="fw-bold text-dark">${{ number_format($product->b2c_price, 2) }}</span>
                                                @if ($product->b2c_compare_price > $product->b2c_price)
                                                    <small class="text-muted ms-1">
                                                        <del>${{ number_format($product->b2c_compare_price, 2) }}</del>
                                                    </small>
                                                @endif
                                            </div>
                                            <div class="text-info small">
                                                <i class="fas fa-building me-1"></i>
                                                B2B: ${{ number_format($product->b2b_price, 2) }}
                                            </div>
                                            <div class="text-muted small">MOQ: {{ $product->b2b_moq }}</div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1">
                                                <span class="badge bg-{{ $product->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                                <span class="badge bg-{{ $product->verification_status === 'approved' ? 'primary' : ($product->verification_status === 'pending' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($product->verification_status) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-1 justify-content-center">
                                                <a href="{{ route('seller.products.edit', $product->id) }}" 
                                                    class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('seller.products.destroy', $product->id) }}" 
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger"
                                                        onclick="return confirm('Are you sure you want to delete this product?')"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-4 d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                        </div>
                        <div>
                            {{ $products->appends(request()->query())->links('pagination.custom-bootstrap-5') }}
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="mb-2">No Products Found</h4>
                        <p class="text-muted mb-4">
                            @if(request()->hasAny(['search', 'status', 'stock_range', 'price_range']))
                                No products match your current filters. Try adjusting your search criteria.
                            @else
                                You haven't added any products yet. Start by adding your first product.
                            @endif
                        </p>
                        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add Your First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
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
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: #2c3e50;
            line-height: 1;
        }

        .stat-title {
            font-size: 0.875rem;
            color: #7f8c8d;
            font-weight: 500;
        }

        .filter-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1.5rem;
        }

        .search-form {
            position: relative;
        }

        .search-form .form-control {
            padding-left: 2.5rem;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .search-form .form-control:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }

        .search-form i {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }

        .form-select {
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .form-select:focus {
            border-color: #4361ee;
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.15);
        }

        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .filter-tag {
            background: white;
            padding: 0.4rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid #dee2e6;
        }

        .filter-tag .close {
            font-size: 1.25rem;
            line-height: 1;
            cursor: pointer;
            text-decoration: none;
            color: #dc3545;
            transition: color 0.2s;
        }

        .filter-tag .close:hover {
            color: #bb2d3b;
        }

        .card {
            border: none;
            border-radius: 12px;
        }

        .product-list-img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #e9ecef;
            flex-shrink: 0;
        }

        .product-list-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 8px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 1rem 0.75rem;
        }

        .table tbody td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }

        .table-hover tbody tr {
            transition: background-color 0.2s;
        }

        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            padding: 0.4em 0.75em;
            border-radius: 6px;
            font-weight: 500;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .btn {
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .page-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .stats-cards {
                grid-template-columns: 1fr;
            }

            .table-responsive {
                font-size: 0.875rem;
            }

            .product-list-img {
                width: 50px;
                height: 50px;
            }
        }
    </style>
@endsection