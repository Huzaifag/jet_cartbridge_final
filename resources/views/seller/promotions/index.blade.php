@extends('seller.layouts.app')

<style>
    .stat-card {
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
    }

    .stat-value {
        font-size: 2.25rem;
        font-weight: 700;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
    }

    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .promotion-details {
        background: #f9fafb;
        border-left: 4px solid #0d6efd;
        padding: 10px 15px;
        margin-top: 5px;
        border-radius: 6px;
    }

    .promotion-details ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
</style>

@section('content')
    <div class="container-fluid py-4">

        <header class="mb-4 pb-3 border-bottom">
            <h1 class="fw-bolder mb-0 text-dark">Promotions & Lucky Draws</h1>
            <p class="text-muted mt-1">Manage all your offers, discounts, and lucky draws in one place.</p>
        </header>

        @php
            $totalPromotions = $promotions->total();
            $activePromotions = $promotions->where('status', 'active')->count();
            $buyGetCount = $promotions->where('type', 'buy_get')->count();
            $luckyDrawCount = $promotions->where('type', 'lucky_draw')->count();
        @endphp

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="stat-card bg-primary-subtle border border-primary">
                    <div class="stat-label text-primary">Total Promotions</div>
                    <div class="stat-value text-primary">{{ $totalPromotions }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-success-subtle border border-success">
                    <div class="stat-label text-success">Active Promotions</div>
                    <div class="stat-value text-success">{{ $activePromotions }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-warning-subtle border border-warning">
                    <div class="stat-label text-warning">Buy X Get Y</div>
                    <div class="stat-value text-warning">{{ $buyGetCount }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card bg-info-subtle border border-info">
                    <div class="stat-label text-info">Lucky Draws</div>
                    <div class="stat-value text-info">{{ $luckyDrawCount }}</div>
                </div>
            </div>
        </div>

        <div class="card p-3 mb-4 shadow-sm">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search by Title"
                        value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">Filter by Type</option>
                        <option value="buy_get" {{ request('type') == 'buy_get' ? 'selected' : '' }}>Buy X Get Y</option>
                        <option value="lucky_draw" {{ request('type') == 'lucky_draw' ? 'selected' : '' }}>Lucky Draw
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Filter by Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-1"></i> Apply
                    </button>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold py-3 border-bottom d-flex justify-content-between align-items-center">
                Promotions List (Page {{ $promotions->currentPage() }} of {{ $promotions->lastPage() }})
                <a href="{{ route('seller.promotions.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus-circle me-1"></i> Add New Promotion
                </a>
            </div>

            {{-- TABS --}}
            <ul class="nav nav-tabs px-3 pt-3" id="promotionTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="buyGet-tab" data-bs-toggle="tab" data-bs-target="#buyGet"
                        type="button" role="tab" aria-controls="buyGet" aria-selected="true">
                        <i class="fas fa-tags me-1"></i> Buy X Get Y
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="luckyDraw-tab" data-bs-toggle="tab" data-bs-target="#luckyDraw"
                        type="button" role="tab" aria-controls="luckyDraw" aria-selected="false">
                        <i class="fas fa-gift me-1"></i> Lucky Draws
                    </button>
                </li>
            </ul>

            <div class="tab-content p-3" id="promotionTabsContent">

                {{-- 🟡 BUY X GET Y TAB --}}
                <div class="tab-pane fade show active" id="buyGet" role="tabpanel" aria-labelledby="buyGet-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Title</th>
                                    <th>Start - End</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($promotions->where('type', 'buy_get') as $promotion)
                                    @php
                                        $statusClass = $promotion->status == 'active' ? 'success' : 'secondary';
                                    @endphp
                                    <tr>
                                        <td><span class="fw-bold text-primary">#{{ $promotion->id }}</span></td>
                                        <td class="fw-semibold">{{ $promotion->title }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($promotion->start_date)->format('M d, Y') }}
                                            –
                                            {{ \Carbon\Carbon::parse($promotion->end_date)->format('M d, Y') }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $statusClass }}">{{ ucfirst($promotion->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('seller.promotions.edit', $promotion->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('seller.promotions.destroy', $promotion->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this promotion?')" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Details --}}
                                    <tr>
                                        <td colspan="5">
                                            <div class="promotion-details">
                                                <h6 class="fw-bold text-warning mb-2"><i class="fas fa-tags me-1"></i> Buy
                                                    X Get Y Details</h6>
                                                <ul>
                                                    @foreach ($promotion->rules as $rule)
                                                        <li>
                                                            Buy <strong>{{ $rule->buy_quantity }}</strong> of
                                                            <strong>{{ $rule->product->name ?? 'N/A' }}</strong>,
                                                            get <strong>{{ $rule->get_quantity }}</strong> free.
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No Buy X Get Y promotions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- 🎁 LUCKY DRAW TAB --}}
                <div class="tab-pane fade" id="luckyDraw" role="tabpanel" aria-labelledby="luckyDraw-tab">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Title</th>
                                    <th>Draw Date</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($promotions->where('type', 'lucky_draw') as $promotion)
                                    @php
                                        $statusClass = $promotion->status == 'active' ? 'success' : 'secondary';
                                    @endphp
                                    <tr>
                                        <td><span class="fw-bold text-primary">#{{ $promotion->id }}</span></td>
                                        <td class="fw-semibold">{{ $promotion->title }}</td>
                                        <td>{{ $promotion->luckyDraw->draw_date ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $statusClass }}">{{ ucfirst($promotion->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('seller.promotions.edit', $promotion->id) }}"
                                                class="btn btn-sm btn-outline-info" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            @if ($promotion->luckyDraw)
                                                <a href="{{ route('seller.lucky-draw.entries', $promotion->luckyDraw->id) }}"
                                                    class="btn btn-sm btn-outline-success" title="View Lucky Draw">
                                                    <i class="fas fa-ticket-alt"></i>
                                                </a>
                                            @endif

                                            <form action="{{ route('seller.promotions.destroy', $promotion->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Delete this promotion?')" title="Delete">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    {{-- Lucky Draw Details --}}
                                    <tr>
                                        <td colspan="5">
                                            <div class="promotion-details">
                                                <h6 class="fw-bold text-info mb-2"><i class="fas fa-gift me-1"></i> Lucky
                                                    Draw Details</h6>
                                                <p class="mb-1">Entries:
                                                    {{ $promotion->luckyDraw->entries->count() ?? 0 }}</p>
                                                @if ($promotion->luckyDraw->winner)
                                                    <p class="mb-0 text-success">Winner:
                                                        {{ $promotion->luckyDraw->winner->name }}</p>
                                                @else
                                                    <p class="mb-0 text-muted">No winner selected yet.</p>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">No Lucky Draw promotions found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="p-3">
                {{ $promotions->links() }}
            </div>
        </div>

    </div>
@endsection
