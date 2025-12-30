@extends('manufacturer.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Coins & Rewards</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('manufacturer.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Coins & Rewards</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Coins Overview -->
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-1">
                            <p class="text-truncate font-size-14 mb-2">Current Balance</p>
                            <h4 class="mb-2">{{ number_format($coinsData['current_balance'] ?? 0) }} <small class="text-muted">coins</small></h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    Available to spend
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-warning-subtle text-warning rounded-3">
                                <i class="fas fa-coins font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Total Earned</p>
                            <h4 class="mb-2">{{ number_format($coinsData['total_earned'] ?? 0) }} <small class="text-muted">coins</small></h4>
                            <p class="text-muted mb-0">
                                <span class="text-success fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    All time earnings
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-success-subtle text-success rounded-3">
                                <i class="fas fa-chart-line font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Current Tier</p>
                            <h4 class="mb-2">{{ $coinsData['tier'] ?? 'Bronze' }} <small class="text-muted">member</small></h4>
                            <p class="text-muted mb-0">
                                <span class="text-info fw-bold font-size-12 me-2">
                                    <i class="ri-arrow-right-up-line me-1 align-middle"></i>
                                    {{ $coinsData['points_to_next_tier'] ?? 0 }} to {{ $coinsData['next_tier'] ?? 'Silver' }}
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-info-subtle text-info rounded-3">
                                <i class="fas fa-crown font-size-24"></i>
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
                            <p class="text-truncate font-size-14 mb-2">Pending Rewards</p>
                            <h4 class="mb-2">{{ number_format($coinsData['pending_rewards'] ?? 0) }} <small class="text-muted">coins</small></h4>
                            <p class="text-muted mb-0">
                                <span class="text-warning fw-bold font-size-12 me-2">
                                    <i class="ri-time-line me-1 align-middle"></i>
                                    Processing
                                </span>
                            </p>
                        </div>
                        <div class="avatar-sm">
                            <span class="avatar-title bg-primary-subtle text-primary rounded-3">
                                <i class="fas fa-hourglass-half font-size-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Daily Bonus & Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="mb-2">Daily Bonus Available!</h5>
                            <p class="text-muted mb-0">Claim your daily bonus to earn extra coins. Come back every day to maximize your earnings!</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <button type="button" class="btn btn-warning btn-lg" onclick="claimDailyBonus()">
                                <i class="fas fa-gift me-2"></i> Claim Daily Bonus
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Tabs -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#rewards" role="tab">
                                <i class="fas fa-gift me-1"></i> Available Rewards
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#transactions" role="tab">
                                <i class="fas fa-history me-1"></i> Transaction History
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#earning" role="tab">
                                <i class="fas fa-coins me-1"></i> Earning Opportunities
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#tiers" role="tab">
                                <i class="fas fa-crown me-1"></i> Membership Tiers
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Available Rewards Tab -->
                        <div class="tab-pane show active" id="rewards" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="mb-0">Available Rewards</h5>
                                    <p class="text-muted">Redeem your coins for exclusive rewards and benefits</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <select class="form-select" id="categoryFilter" style="width: auto;">
                                            <option value="">All Categories</option>
                                            <option value="tools">Tools</option>
                                            <option value="marketing">Marketing</option>
                                            <option value="support">Support</option>
                                            <option value="branding">Branding</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @forelse($availableRewards ?? [] as $reward)
                                    <div class="col-xl-4 col-md-6 reward-card" data-category="{{ $reward['category'] }}">
                                        <div class="card reward-item {{ !$reward['available'] ? 'unavailable' : '' }}">
                                            <div class="card-body">
                                                @if($reward['popular'])
                                                    <div class="ribbon ribbon-top-right">
                                                        <span class="bg-primary">Popular</span>
                                                    </div>
                                                @endif
                                                
                                                <div class="text-center mb-3">
                                                    <div class="avatar-lg mx-auto mb-3">
                                                        <span class="avatar-title bg-{{ $reward['category'] === 'tools' ? 'primary' : ($reward['category'] === 'marketing' ? 'success' : ($reward['category'] === 'support' ? 'info' : 'warning')) }}-subtle text-{{ $reward['category'] === 'tools' ? 'primary' : ($reward['category'] === 'marketing' ? 'success' : ($reward['category'] === 'support' ? 'info' : 'warning')) }} rounded-circle">
                                                            <i class="fas fa-{{ $reward['category'] === 'tools' ? 'chart-bar' : ($reward['category'] === 'marketing' ? 'bullhorn' : ($reward['category'] === 'support' ? 'headset' : 'palette')) }} font-size-24"></i>
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-1">{{ $reward['title'] }}</h6>
                                                    <p class="text-muted mb-3">{{ $reward['description'] }}</p>
                                                </div>

                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <div class="coin-cost">
                                                        <span class="h5 text-warning mb-0">
                                                            <i class="fas fa-coins me-1"></i>{{ number_format($reward['cost']) }}
                                                        </span>
                                                        <small class="text-muted d-block">coins required</small>
                                                    </div>
                                                    <span class="badge bg-{{ $reward['category'] === 'tools' ? 'primary' : ($reward['category'] === 'marketing' ? 'success' : ($reward['category'] === 'support' ? 'info' : 'warning')) }}-subtle text-{{ $reward['category'] === 'tools' ? 'primary' : ($reward['category'] === 'marketing' ? 'success' : ($reward['category'] === 'support' ? 'info' : 'warning')) }}">
                                                        {{ ucfirst($reward['category']) }}
                                                    </span>
                                                </div>

                                                <div class="d-grid">
                                                    @if($reward['available'])
                                                        @if(($coinsData['current_balance'] ?? 0) >= $reward['cost'])
                                                            <button type="button" class="btn btn-primary" onclick="redeemReward({{ $reward['id'] }}, {{ $reward['cost'] }}, '{{ $reward['title'] }}')">
                                                                <i class="fas fa-gift me-1"></i> Redeem Now
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-outline-secondary" disabled>
                                                                <i class="fas fa-lock me-1"></i> Insufficient Coins
                                                            </button>
                                                        @endif
                                                    @else
                                                        <button type="button" class="btn btn-outline-secondary" disabled>
                                                            <i class="fas fa-times me-1"></i> Currently Unavailable
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="fas fa-gift fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No rewards available</h5>
                                            <p class="text-muted">Check back later for new rewards and offers.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Transaction History Tab -->
                        <div class="tab-pane" id="transactions" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5 class="mb-0">Transaction History</h5>
                                    <p class="text-muted">Track your coin earnings and redemptions</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <select class="form-select" id="transactionFilter" style="width: auto;">
                                            <option value="">All Transactions</option>
                                            <option value="earned">Earned</option>
                                            <option value="redeemed">Redeemed</option>
                                        </select>
                                        <button type="button" class="btn btn-success" onclick="exportTransactions()">
                                            <i class="fas fa-download me-1"></i> Export
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-nowrap align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($transactions ?? [] as $transaction)
                                            <tr class="transaction-row" data-type="{{ $transaction['type'] }}">
                                                <td>{{ \Carbon\Carbon::parse($transaction['date'])->format('M d, Y') }}</td>
                                                <td>{{ $transaction['description'] }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $transaction['type'] === 'earned' ? 'success' : 'warning' }}-subtle text-{{ $transaction['type'] === 'earned' ? 'success' : 'warning' }}">
                                                        {{ ucfirst($transaction['type']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold {{ $transaction['type'] === 'earned' ? 'text-success' : 'text-warning' }}">
                                                        {{ $transaction['type'] === 'earned' ? '+' : '' }}{{ number_format($transaction['amount']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-success-subtle text-success">
                                                        {{ ucfirst($transaction['status']) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <code>{{ $transaction['reference'] }}</code>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                                    <p class="text-muted">No transactions found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Earning Opportunities Tab -->
                        <div class="tab-pane" id="earning" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h5 class="mb-0">How to Earn Coins</h5>
                                    <p class="text-muted">Discover different ways to earn coins and maximize your rewards</p>
                                </div>
                            </div>

                            <div class="row">
                                @forelse($earningOpportunities ?? [] as $opportunity)
                                    <div class="col-xl-6 col-lg-12">
                                        <div class="card earning-opportunity">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-1">
                                                        <h6 class="mb-2">{{ $opportunity['title'] }}</h6>
                                                        <p class="text-muted mb-2">{{ $opportunity['description'] }}</p>
                                                        <small class="text-muted">{{ $opportunity['frequency'] }}</small>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="coin-reward">
                                                            <span class="h5 text-warning mb-0">
                                                                <i class="fas fa-coins me-1"></i>{{ $opportunity['coins'] }}
                                                            </span>
                                                            <small class="text-muted d-block">coins</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="text-center py-5">
                                            <i class="fas fa-coins fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No earning opportunities</h5>
                                            <p class="text-muted">Check back later for new ways to earn coins.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Membership Tiers Tab -->
                        <div class="tab-pane" id="tiers" role="tabpanel">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <h5 class="mb-0">Membership Tiers</h5>
                                    <p class="text-muted">Unlock exclusive benefits as you earn more coins</p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="tier-progress mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="fw-bold">Current Progress: {{ $coinsData['tier'] ?? 'Bronze' }} Tier</span>
                                            <span class="text-muted">{{ $coinsData['points_to_next_tier'] ?? 0 }} coins to {{ $coinsData['next_tier'] ?? 'Silver' }}</span>
                                        </div>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-warning" style="width: 75%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                @php
                                    $tiers = [
                                        ['name' => 'Bronze', 'requirement' => '0+', 'color' => 'secondary', 'benefits' => ['Basic support', '5% bonus coins']],
                                        ['name' => 'Silver', 'requirement' => '1,000+', 'color' => 'info', 'benefits' => ['Priority support', '10% bonus coins', 'Monthly rewards']],
                                        ['name' => 'Gold', 'requirement' => '3,000+', 'color' => 'warning', 'benefits' => ['24/7 support', '15% bonus coins', 'Weekly rewards', 'Featured listings']],
                                        ['name' => 'Platinum', 'requirement' => '10,000+', 'color' => 'primary', 'benefits' => ['Dedicated manager', '20% bonus coins', 'Daily rewards', 'Premium features']]
                                    ];
                                @endphp

                                @foreach($tiers as $tier)
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card tier-card {{ ($coinsData['tier'] ?? 'Bronze') === $tier['name'] ? 'current-tier' : '' }}">
                                            <div class="card-body text-center">
                                                @if(($coinsData['tier'] ?? 'Bronze') === $tier['name'])
                                                    <div class="ribbon ribbon-top-right">
                                                        <span class="bg-success">Current</span>
                                                    </div>
                                                @endif
                                                
                                                <div class="avatar-lg mx-auto mb-3">
                                                    <span class="avatar-title bg-{{ $tier['color'] }}-subtle text-{{ $tier['color'] }} rounded-circle">
                                                        <i class="fas fa-crown font-size-24"></i>
                                                    </span>
                                                </div>
                                                
                                                <h5 class="mb-1">{{ $tier['name'] }}</h5>
                                                <p class="text-muted mb-3">{{ $tier['requirement'] }} coins</p>
                                                
                                                <ul class="list-unstyled mb-0">
                                                    @foreach($tier['benefits'] as $benefit)
                                                        <li class="mb-1">
                                                            <i class="fas fa-check text-success me-2"></i>
                                                            {{ $benefit }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.reward-item.unavailable {
    opacity: 0.6;
}

.ribbon {
    position: absolute;
    right: -5px;
    top: -5px;
    z-index: 1;
    overflow: hidden;
    width: 75px;
    height: 75px;
    text-align: right;
}

.ribbon span {
    font-size: 10px;
    font-weight: bold;
    color: #FFF;
    text-transform: uppercase;
    text-align: center;
    line-height: 20px;
    transform: rotate(45deg);
    -webkit-transform: rotate(45deg);
    width: 100px;
    display: block;
    position: absolute;
    top: 19px;
    right: -21px;
}

.tier-card.current-tier {
    border: 2px solid #28a745;
    box-shadow: 0 0 15px rgba(40, 167, 69, 0.3);
}

.earning-opportunity {
    transition: transform 0.2s;
}

.earning-opportunity:hover {
    transform: translateY(-2px);
}

.coin-cost, .coin-reward {
    text-align: center;
}
</style>
@endsection

@push('scripts')
<script>
// Filter functionality
document.getElementById('categoryFilter').addEventListener('change', function() {
    const category = this.value;
    const cards = document.querySelectorAll('.reward-card');
    
    cards.forEach(card => {
        if (!category || card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
});

document.getElementById('transactionFilter').addEventListener('change', function() {
    const type = this.value;
    const rows = document.querySelectorAll('.transaction-row');
    
    rows.forEach(row => {
        if (!type || row.dataset.type === type) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

// Reward redemption
function redeemReward(rewardId, cost, title) {
    if (confirm(`Are you sure you want to redeem "${title}" for ${cost} coins?`)) {
        // Here you would typically send a request to your backend
        console.log('Redeeming reward:', rewardId);
        
        // Simulate API call
        setTimeout(() => {
            alert('Reward redeemed successfully!');
            // Refresh the page or update the UI
            location.reload();
        }, 1000);
    }
}

// Daily bonus claim
function claimDailyBonus() {
    // Here you would typically send a request to your backend
    console.log('Claiming daily bonus');
    
    // Simulate API call
    setTimeout(() => {
        const bonusAmount = Math.floor(Math.random() * 40) + 10;
        alert(`Daily bonus claimed! You earned ${bonusAmount} coins.`);
        // Update the UI or refresh
        location.reload();
    }, 1000);
}

// Export transactions
function exportTransactions() {
    console.log('Exporting transactions');
    // Implementation for exporting transaction history
}

// Auto-refresh coins balance every 60 seconds
setInterval(function() {
    // Here you would fetch updated balance from your backend
    console.log('Checking for balance updates...');
}, 60000);
</script>
@endpush