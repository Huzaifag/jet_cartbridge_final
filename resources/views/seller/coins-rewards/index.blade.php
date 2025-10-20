@extends('seller.layouts.app')

@section('content')
    <style>
        :root {
            --gold: #ffd700;
            --silver: #c0c0c0;
            --bronze: #cd7f32;
        }


        .dashboard-widget {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 1.5rem;
            transition: transform 0.2s;
        }

        .dashboard-widget:hover {
            transform: translateY(-5px);
        }

        .widget-header {
            padding: 1rem 1.35rem;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .widget-body {
            padding: 1.35rem;
        }

        .coin-balance {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gold);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
            margin-bottom: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin: 20px 0;
        }

        .stat-card {
            background: var(--light);
            border-radius: 8px;
            padding: 15px;
            text-align: center;
        }

        .stat-value {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0;
        }

        .stat-label {
            color: var(--dark);
            font-size: 0.85rem;
            margin-bottom: 0;
        }

        .btn-coin {
            background: linear-gradient(135deg, var(--gold), #ffcc00);
            color: #000;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .btn-coin:hover {
            background: linear-gradient(135deg, #ffcc00, var(--gold));
            transform: scale(1.05);
        }

        .btn-refer {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            transition: all 0.3s;
        }

        .btn-refer:hover {
            background: linear-gradient(135deg, var(--secondary), var(--primary));
            transform: scale(1.05);
        }

        .transaction-table {
            width: 100%;
            border-collapse: collapse;
        }

        .transaction-table th {
            background-color: var(--light);
            padding: 12px 15px;
            text-align: left;
            font-weight: 700;
            color: var(--dark);
        }

        .transaction-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e3e6f0;
        }

        .transaction-table tr:hover {
            background-color: #f8f9fc;
        }

        .badge-earned {
            background-color: rgba(28, 200, 138, 0.2);
            color: var(--success);
            padding: 0.35rem 0.7rem;
            border-radius: 0.35rem;
            font-weight: 600;
        }

        .badge-redeemed {
            background-color: rgba(231, 74, 59, 0.2);
            color: var(--danger);
            padding: 0.35rem 0.7rem;
            border-radius: 0.35rem;
            font-weight: 600;
        }

        .badge-pending {
            background-color: rgba(246, 194, 62, 0.2);
            color: var(--warning);
            padding: 0.35rem 0.7rem;
            border-radius: 0.35rem;
            font-weight: 600;
        }

        .referral-box {
            background: var(--light);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .copy-input-group {
            display: flex;
            margin-bottom: 10px;
        }

        .copy-input {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px 0 0 8px;
            font-family: monospace;
        }

        .copy-btn {
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 0 8px 8px 0;
            padding: 0 15px;
            cursor: pointer;
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 10px 10px 0 0;
            padding: 1rem 1.5rem;
        }

        .reward-option {
            border: 2px solid #e3e6f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .reward-option:hover {
            border-color: var(--primary);
            background-color: #f8f9fc;
        }

        .reward-option.selected {
            border-color: var(--primary);
            background-color: rgba(78, 115, 223, 0.1);
        }

        .reward-cost {
            font-weight: 700;
            color: var(--gold);
        }

        .tab-content {
            padding: 20px 0;
        }

        .nav-tabs .nav-link {
            border: none;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: var(--dark);
            border-radius: 0;
        }

        .nav-tabs .nav-link.active {
            color: var(--primary);
            border-bottom: 3px solid var(--primary);
            background: transparent;
        }
    </style>
</head>


    <div class="container">
        <!-- Dashboard Header -->
        <div class="row mb-4">
            <div class="col">
                <h1 class="h3 mb-0 text-gray-800">Seller Dashboard</h1>
                <p class="text-muted">Manage your business and track performance</p>
            </div>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Coins & Rewards Widget -->
                <div class="dashboard-widget">
                    <div class="widget-header">
                        <h5 class="m-0"><i class="fas fa-coins me-2 text-warning"></i> Coins & Rewards</h5>
                        <i class="fas fa-info-circle text-muted"></i>
                    </div>
                    <div class="widget-body">
                        <div class="text-center mb-4">
                            <p class="text-muted mb-1">Your Current Balance</p>
                            <h1 class="coin-balance">1,250</h1>
                            <p class="text-muted">Coins</p>
                        </div>

                        <div class="stats-grid">
                            <div class="stat-card">
                                <p class="stat-value text-success">350</p>
                                <p class="stat-label">Earned This Month</p>
                            </div>
                            <div class="stat-card">
                                <p class="stat-value text-danger">100</p>
                                <p class="stat-label">Redeemed</p>
                            </div>
                            <div class="stat-card">
                                <p class="stat-value text-primary">18</p>
                                <p class="stat-label">Referrals</p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <button class="btn btn-refer" data-bs-toggle="modal" data-bs-target="#referralModal">
                                <i class="fas fa-user-plus me-1"></i> Refer & Earn
                            </button>
                            <button class="btn btn-coin" data-bs-toggle="modal" data-bs-target="#redemptionModal">
                                <i class="fas fa-gift me-1"></i> Redeem Now
                            </button>
                        </div>

                        <h6 class="mb-3"><i class="fas fa-history me-2 text-muted"></i> Rewards History</h6>

                        <div class="table-responsive">
                            <table class="transaction-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Coins</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sep 5, 2023</td>
                                        <td>Order Completion</td>
                                        <td class="text-success">+50</td>
                                        <td><span class="badge-earned">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Sep 3, 2023</td>
                                        <td>Referral Bonus</td>
                                        <td class="text-success">+100</td>
                                        <td><span class="badge-earned">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Sep 1, 2023</td>
                                        <td>Reward Redemption</td>
                                        <td class="text-danger">-100</td>
                                        <td><span class="badge-redeemed">Redeemed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Aug 28, 2023</td>
                                        <td>Monthly Bonus</td>
                                        <td class="text-success">+200</td>
                                        <td><span class="badge-earned">Completed</span></td>
                                    </tr>
                                    <tr>
                                        <td>Aug 15, 2023</td>
                                        <td>Referral Bonus</td>
                                        <td class="text-success">+100</td>
                                        <td><span class="badge-pending">Processing</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Referral Section -->
                <div class="dashboard-widget">
                    <div class="widget-header">
                        <h5 class="m-0"><i class="fas fa-user-friends me-2 text-primary"></i> Referral Program</h5>
                    </div>
                    <div class="widget-body">
                        <p class="text-muted">Share your referral link and earn 100 coins for every successful referral.
                        </p>

                        <div class="referral-box">
                            <label class="form-label">Your Referral Link</label>
                            <div class="copy-input-group">
                                <input type="text" class="copy-input" value="https://myapp.com/register?ref=SELLER78923"
                                    id="referralLink">
                                <button class="copy-btn" onclick="copyReferralLink()">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <small class="text-muted">Click to copy and share with your network</small>
                        </div>

                        <div class="d-grid gap-2 mt-3">
                            <button class="btn btn-outline-primary">
                                <i class="fas fa-share-alt me-1"></i> Share via Social Media
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Rewards Tips -->
                <div class="dashboard-widget">
                    <div class="widget-header">
                        <h5 class="m-0"><i class="fas fa-lightbulb me-2 text-warning"></i> Earning Tips</h5>
                    </div>
                    <div class="widget-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Complete orders to earn coins</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Refer other sellers for bonus coins</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Get monthly bonuses for active sellers</span>
                            </li>
                            <li class="list-group-item d-flex align-items-center">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span>Redeem coins for discounts and perks</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Referral Modal -->
    <div class="modal fade" id="referralModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-user-plus me-2"></i> Refer & Earn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Earn <strong>100 coins</strong> for every seller who joins using your referral link and completes
                        their first order.</p>

                    <div class="mb-3">
                        <label class="form-label">Your Referral Link</label>
                        <div class="copy-input-group">
                            <input type="text" class="copy-input" value="https://myapp.com/register?ref=SELLER78923"
                                id="modalReferralLink">
                            <button class="copy-btn" onclick="copyModalReferralLink()">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Share via</label>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="fab fa-facebook me-2"></i> Facebook
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="fab fa-twitter me-2"></i> Twitter
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="fab fa-linkedin me-2"></i> LinkedIn
                            </button>
                            <button class="btn btn-outline-danger">
                                <i class="fas fa-envelope me-2"></i> Email
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Redemption Modal -->
    <div class="modal fade" id="redemptionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-gift me-2"></i> Redeem Your Coins</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <p class="mb-0 text-muted">Available Balance</p>
                            <h3 class="coin-balance mb-0">1,250 <small class="text-muted"
                                    style="font-size: 1rem;">coins</small></h3>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 text-muted">Equivalent Value</p>
                            <h4 class="mb-0">$125</h4>
                        </div>
                    </div>

                    <ul class="nav nav-tabs" id="redemptionTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="discount-tab" data-bs-toggle="tab"
                                data-bs-target="#discount" type="button" role="tab">
                                Discount Coupons
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="payout-tab" data-bs-toggle="tab" data-bs-target="#payout"
                                type="button" role="tab">
                                Payouts
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="upgrade-tab" data-bs-toggle="tab" data-bs-target="#upgrade"
                                type="button" role="tab">
                                Account Upgrades
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="redemptionTabContent">
                        <div class="tab-pane fade show active" id="discount" role="tabpanel">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$5 Discount Coupon</h5>
                                        <p class="text-muted">Use on your next purchase</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 50 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$10 Discount Coupon</h5>
                                        <p class="text-muted">Use on your next purchase</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 100 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$25 Discount Coupon</h5>
                                        <p class="text-muted">Use on your next purchase</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 250 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$50 Discount Coupon</h5>
                                        <p class="text-muted">Use on your next purchase</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 500 coins</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="payout" role="tabpanel">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$10 Cash Payout</h5>
                                        <p class="text-muted">Direct transfer to your bank account</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 120 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$25 Cash Payout</h5>
                                        <p class="text-muted">Direct transfer to your bank account</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 300 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$50 Cash Payout</h5>
                                        <p class="text-muted">Direct transfer to your bank account</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 600 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>$100 Cash Payout</h5>
                                        <p class="text-muted">Direct transfer to your bank account</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 1200 coins</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="upgrade" role="tabpanel">
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>Featured Listing</h5>
                                        <p class="text-muted">Feature one product for 7 days</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 200 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>Store Highlight</h5>
                                        <p class="text-muted">Get featured on our homepage for 24 hours</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 500 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>Premium Badge</h5>
                                        <p class="text-muted">Show a premium badge on your store for 30 days</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 300 coins</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="reward-option" onclick="selectReward(this)">
                                        <h5>Analytics Upgrade</h5>
                                        <p class="text-muted">Get advanced analytics for 30 days</p>
                                        <p class="reward-cost"><i class="fas fa-coins me-1"></i> 400 coins</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="processRedemption()">Redeem Now</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Copy referral link function
        function copyReferralLink() {
            const copyText = document.getElementById("referralLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            alert("Copied referral link: " + copyText.value);
        }

        function copyModalReferralLink() {
            const copyText = document.getElementById("modalReferralLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            alert("Copied referral link: " + copyText.value);
        }

        // Reward selection function
        function selectReward(element) {
            // Remove selected class from all options
            document.querySelectorAll('.reward-option').forEach(opt => {
                opt.classList.remove('selected');
            });

            // Add selected class to clicked option
            element.classList.add('selected');
        }

        // Process redemption function
        function processRedemption() {
            const selectedOption = document.querySelector('.reward-option.selected');
            if (!selectedOption) {
                alert("Please select a reward to redeem.");
                return;
            }

            alert("Redemption processed successfully! Your coins have been deducted.");
            document.getElementById('redemptionModal').querySelector('.btn-close').click();
        }

        // Initialize tab functionality
        document.addEventListener('DOMContentLoaded', function () {
            const triggerTabList = document.querySelectorAll('#redemptionTabs button');
            triggerTabList.forEach(triggerEl => {
                triggerEl.addEventListener('click', event => {
                    event.preventDefault();
                    const tab = new bootstrap.Tab(triggerEl);
                    tab.show();
                });
            });
        });
    </script>
@endsection

