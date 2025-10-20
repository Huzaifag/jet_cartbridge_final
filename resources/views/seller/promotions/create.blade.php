@extends('seller.layouts.app')


@section('content')
<div class="container-fluid py-4">

    <header class="mb-4 pb-3 border-bottom">
        <h1 class="fw-bolder mb-0 text-dark">Create New Promotion</h1>
        <p class="text-muted mt-1">Add new offers such as “Buy X Get Y” or Lucky Draws.</p>
    </header>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold py-3 border-bottom">
            <i class="fas fa-gift me-2 text-primary"></i> Promotion Details
        </div>

        <div class="card-body">
            <form action="{{ route('seller.promotions.store') }}" method="POST" id="promotionForm">
                @csrf

                {{-- Promotion Basic Info --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Promotion Title</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Buy 2 Get 1 Free" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Promotion Type</label>
                        <select name="type" id="promotionType" class="form-select" required>
                            <option value="">Select Type</option>
                            <option value="buy_get">Buy X Get Y</option>
                            <option value="lucky_draw">Lucky Draw</option>
                        </select>
                    </div>
                </div>

                {{-- Date Range --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>

                {{-- Dynamic Fields (Based on Type) --}}
                <div id="buyGetSection" class="type-section d-none">
                    <h5 class="border-bottom pb-2 mb-3 text-primary"><i class="fas fa-shopping-bag me-1"></i> Buy X Get Y Rule</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Buy Quantity</label>
                            <input type="number" name="buy_quantity" class="form-control" min="1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Get Quantity</label>
                            <input type="number" name="get_quantity" class="form-control" min="1">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Applicable Product</label>
                            <select name="applicable_product_id" class="form-select">
                                <option value="">Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Applicable Tag (optional)</label>
                            <input type="text" name="applicable_tag" class="form-control" placeholder="e.g. electronics">
                        </div>
                    </div>
                </div>

                <div id="luckyDrawSection" class="type-section d-none">
                    <h5 class="border-bottom pb-2 mb-3 text-success"><i class="fas fa-trophy me-1"></i> Lucky Draw Details</h5>

                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Minimum Purchase</label>
                            <input type="number" name="minimum_purchase" step="0.01" class="form-control" placeholder="e.g. 500.00">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Prize Description</label>
                            <input type="text" name="prize_description" class="form-control" placeholder="e.g. iPhone 16 Giveaway">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Draw Date</label>
                            <input type="date" name="draw_date" class="form-control">
                        </div>
                    </div>
                </div>

                {{-- Status --}}
                <div class="mb-4">
                    <label class="form-check-label fw-semibold">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input me-2" checked>
                        Activate Promotion Immediately
                    </label>
                </div>

                <div class="text-end">
                    <a href="{{ route('seller.promotions.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Save Promotion
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Inline JS --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('promotionType');
    const sections = document.querySelectorAll('.type-section');

    typeSelect.addEventListener('change', function() {
        sections.forEach(sec => sec.classList.add('d-none'));

        if (this.value === 'buy_get') {
            document.getElementById('buyGetSection').classList.remove('d-none');
        } else if (this.value === 'lucky_draw') {
            document.getElementById('luckyDrawSection').classList.remove('d-none');
        }
    });
});
</script>
@endsection
