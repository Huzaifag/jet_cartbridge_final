<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ManufacturerCoinController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample coins and rewards data
        $coinsData = [
            'current_balance' => 2450,
            'total_earned' => 15680,
            'total_redeemed' => 13230,
            'pending_rewards' => 350,
            'tier' => 'Gold',
            'next_tier' => 'Platinum',
            'points_to_next_tier' => 550
        ];

        // Sample transaction history
        $transactions = [
            [
                'id' => 1,
                'type' => 'earned',
                'amount' => 150,
                'description' => 'Order completion bonus - Order #ORD-2024-001',
                'date' => now()->subDays(1),
                'status' => 'completed',
                'reference' => 'ORD-2024-001'
            ],
            [
                'id' => 2,
                'type' => 'earned',
                'amount' => 200,
                'description' => 'Customer satisfaction bonus - 5-star rating',
                'date' => now()->subDays(3),
                'status' => 'completed',
                'reference' => 'REV-2024-045'
            ],
            [
                'id' => 3,
                'type' => 'redeemed',
                'amount' => -500,
                'description' => 'Redeemed for Premium Analytics Package',
                'date' => now()->subDays(5),
                'status' => 'completed',
                'reference' => 'RED-2024-012'
            ],
            [
                'id' => 4,
                'type' => 'earned',
                'amount' => 100,
                'description' => 'Monthly activity bonus',
                'date' => now()->subDays(7),
                'status' => 'completed',
                'reference' => 'BONUS-2024-01'
            ],
            [
                'id' => 5,
                'type' => 'earned',
                'amount' => 75,
                'description' => 'New product listing bonus',
                'date' => now()->subDays(10),
                'status' => 'completed',
                'reference' => 'PROD-2024-089'
            ]
        ];

        // Sample available rewards
        $availableRewards = [
            [
                'id' => 1,
                'title' => 'Premium Analytics Package',
                'description' => 'Advanced analytics and reporting tools for 3 months',
                'cost' => 500,
                'category' => 'tools',
                'image' => 'analytics-package.jpg',
                'available' => true,
                'popular' => true
            ],
            [
                'id' => 2,
                'title' => 'Featured Product Listing',
                'description' => 'Feature your product on homepage for 7 days',
                'cost' => 300,
                'category' => 'marketing',
                'image' => 'featured-listing.jpg',
                'available' => true,
                'popular' => false
            ],
            [
                'id' => 3,
                'title' => 'Priority Customer Support',
                'description' => '24/7 priority support for 1 month',
                'cost' => 200,
                'category' => 'support',
                'image' => 'priority-support.jpg',
                'available' => true,
                'popular' => false
            ],
            [
                'id' => 4,
                'title' => 'Bulk Order Promotion',
                'description' => 'Promote your bulk order capabilities',
                'cost' => 400,
                'category' => 'marketing',
                'image' => 'bulk-promotion.jpg',
                'available' => true,
                'popular' => true
            ],
            [
                'id' => 5,
                'title' => 'Custom Branding Package',
                'description' => 'Custom branding for your manufacturer profile',
                'cost' => 800,
                'category' => 'branding',
                'image' => 'custom-branding.jpg',
                'available' => false,
                'popular' => false
            ]
        ];

        // Apply filters
        if ($request->has('category') && $request->category) {
            $availableRewards = array_filter($availableRewards, function($reward) use ($request) {
                return $reward['category'] === $request->category;
            });
        }

        if ($request->has('transaction_type') && $request->transaction_type) {
            $transactions = array_filter($transactions, function($transaction) use ($request) {
                return $transaction['type'] === $request->transaction_type;
            });
        }

        // Earning opportunities
        $earningOpportunities = [
            [
                'title' => 'Complete Orders',
                'description' => 'Earn 10-50 coins per completed order',
                'coins' => '10-50',
                'frequency' => 'Per order'
            ],
            [
                'title' => 'Customer Reviews',
                'description' => 'Earn bonus coins for 5-star reviews',
                'coins' => '25-100',
                'frequency' => 'Per review'
            ],
            [
                'title' => 'Monthly Activity',
                'description' => 'Stay active and earn monthly bonuses',
                'coins' => '100-500',
                'frequency' => 'Monthly'
            ],
            [
                'title' => 'New Product Listings',
                'description' => 'Add new products to earn coins',
                'coins' => '50-150',
                'frequency' => 'Per product'
            ]
        ];

        return view('manufacturer.coins-rewards.index', compact(
            'coinsData', 
            'transactions', 
            'availableRewards', 
            'earningOpportunities'
        ));
    }

    public function redeemReward(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reward_id' => 'required|integer',
            'confirm' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $rewardId = $request->reward_id;
        
        // Here you would check if user has enough coins and process the redemption
        // For now, return success response
        return response()->json([
            'success' => true,
            'message' => 'Reward redeemed successfully!',
            'new_balance' => 1950, // Sample new balance
            'transaction_id' => 'RED-' . date('Y') . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT)
        ]);
    }

    public function getTransactionHistory(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 10);
        $type = $request->get('type', 'all');

        // Sample paginated transaction history
        $transactions = [
            // ... transaction data would come from database
        ];

        return response()->json([
            'success' => true,
            'transactions' => $transactions,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => 5,
                'total_records' => 47
            ]
        ]);
    }

    public function getEarningStats(Request $request)
    {
        $period = $request->get('period', '30');

        $stats = [
            'daily_average' => rand(15, 45),
            'weekly_total' => rand(100, 300),
            'monthly_total' => rand(400, 1200),
            'top_earning_source' => 'Order Completions',
            'earning_trend' => $this->generateEarningTrend($period),
            'category_breakdown' => [
                'orders' => rand(40, 60),
                'reviews' => rand(15, 25),
                'bonuses' => rand(10, 20),
                'activities' => rand(5, 15)
            ]
        ];

        return response()->json($stats);
    }

    private function generateEarningTrend($period)
    {
        $trend = [];
        $days = min($period, 30);

        for ($i = $days; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $trend[] = [
                'date' => $date->format('M d'),
                'earned' => rand(10, 80),
                'redeemed' => rand(0, 30)
            ];
        }

        return $trend;
    }

    public function checkRewardAvailability($rewardId)
    {
        // Sample availability check
        $available = rand(0, 1) === 1;
        $userBalance = 2450; // Sample balance
        $rewardCost = 500; // Sample cost

        return response()->json([
            'available' => $available,
            'sufficient_balance' => $userBalance >= $rewardCost,
            'user_balance' => $userBalance,
            'reward_cost' => $rewardCost
        ]);
    }

    public function getTierInfo()
    {
        $tierInfo = [
            'current_tier' => 'Gold',
            'current_points' => 2450,
            'next_tier' => 'Platinum',
            'points_needed' => 550,
            'tier_benefits' => [
                'Bronze' => ['Basic support', '5% bonus coins'],
                'Silver' => ['Priority support', '10% bonus coins', 'Monthly rewards'],
                'Gold' => ['24/7 support', '15% bonus coins', 'Weekly rewards', 'Featured listings'],
                'Platinum' => ['Dedicated manager', '20% bonus coins', 'Daily rewards', 'Premium features', 'Custom branding']
            ],
            'progress_percentage' => 81.6 // (2450 / 3000) * 100
        ];

        return response()->json($tierInfo);
    }

    public function exportTransactions(Request $request)
    {
        $format = $request->get('format', 'excel');
        $dateRange = $request->get('date_range', '30');
        $type = $request->get('type', 'all');

        return response()->json([
            'success' => true,
            'message' => 'Transaction history exported successfully',
            'download_url' => '#',
            'filters' => [
                'format' => $format,
                'date_range' => $dateRange,
                'type' => $type
            ]
        ]);
    }

    public function claimDailyBonus()
    {
        // Check if daily bonus already claimed
        $alreadyClaimed = rand(0, 1) === 1;

        if ($alreadyClaimed) {
            return response()->json([
                'success' => false,
                'message' => 'Daily bonus already claimed today. Come back tomorrow!'
            ]);
        }

        $bonusAmount = rand(10, 50);

        return response()->json([
            'success' => true,
            'message' => 'Daily bonus claimed successfully!',
            'bonus_amount' => $bonusAmount,
            'new_balance' => 2450 + $bonusAmount
        ]);
    }
}