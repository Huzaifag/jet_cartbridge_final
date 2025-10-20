@extends('seller.layouts.app')

@section('content')
<div class="container-fluid py-4">

    <header class="mb-4 pb-3 border-bottom">
        <a href="{{ route('seller.promotions.index') }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-1"></i> Back to Promotions
        </a>
        <h1 class="fw-bolder mb-0 text-dark">Lucky Draw Entries</h1>
        <p class="text-muted mt-1">
            Viewing entries for: <strong class="text-primary">{{ $luckyDraw->promotion->title }}</strong>
        </p>
    </header>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-info"><i class="fas fa-gift me-2"></i>Prize</h5>
                    <p class="card-text fs-5 fw-semibold">{{ $luckyDraw->prize_description }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-success"><i class="fas fa-calendar-check me-2"></i>Draw Date</h5>
                    <p class="card-text fs-5 fw-semibold">{{ \Carbon\Carbon::parse($luckyDraw->draw_date)->format('M d, Y, h:i A') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title text-warning"><i class="fas fa-ticket-alt me-2"></i>Total Entries</h5>
                    <p class="card-text fs-5 fw-semibold">{{ $luckyDraw->entries->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white fw-bold py-3 border-bottom">
            <i class="fas fa-users me-2"></i> Participant List
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Entry ID</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Entry Code</th>
                        <th>Entry Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($luckyDraw->entries as $entry)
                        <tr>
                            <td><span class="fw-bold text-primary">#{{ $entry->id }}</span></td>
                            <td>{{ $entry->customer->name ?? 'N/A' }}</td>
                            <td>{{ $entry->customer->email ?? 'N/A' }}</td>
                            <td><span class="badge bg-secondary">{{ $entry->entry_code }}</span></td>
                            <td>{{ $entry->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4">No entries found for this lucky draw yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
