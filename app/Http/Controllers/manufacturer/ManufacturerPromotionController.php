<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ManufacturerPromotionController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = Auth::user();
        
        // Sample promotions data
        $promotions = [
            [
                'id' => 1,
                'title' => 'Summer Electronics Sale',
                'description' => '25% off on all wireless headphones and smart watches',
                'type' => 'percentage',
                'discount_value' => 25,
                'min_order_amount' => 100.00,
                'max_discount' => 500.00,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'status' => 'active',
                'usage_count' => 45,
                'usage_limit' => 100,
                'applicable_products' => ['Wireless Headphones', 'Smart Watches'],
                'target_audience' => 'all_customers',
                'created_at' => now()->subDays(10)
            ],
            [
                'id' => 2,
                'title' => 'Bulk Order Discount',
                'description' => '$50 off on orders above $1000',
                'type' => 'fixed',
                'discount_value' => 50.00,
                'min_order_amount' => 1000.00,
                'max_discount' => 50.00,
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'status' => 'active',
                'usage_count' => 12,
                'usage_limit' => 50,
                'applicable_products' => ['All Products'],
                'target_audience' => 'business_customers',
                'created_at' => now()->subDays(20)
            ],
            [
                'id' => 3,
                'title' => 'New Customer Welcome',
                'description' => '15% off for first-time customers',
                'type' => 'percentage',
                'discount_value' => 15,
                'min_order_amount' => 50.00,
                'max_discount' => 100.00,
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
                'status' => 'active',
                'usage_count' => 78,
                'usage_limit' => 200,
                'applicable_products' => ['All Products'],
                'target_audience' => 'new_customers',
                'created_at' => now()->subDays(35)
            ],
            [
                'id' => 4,
                'title' => 'Flash Sale - Bluetooth Speakers',
                'description' => '40% off on all Bluetooth speakers - Limited time!',
                'type' => 'percentage',
                'discount_value' => 40,
                'min_order_amount' => 0,
                'max_discount' => 200.00,
                'start_date' => now()->subDays(2),
                'end_date' => now()->addDays(3),
                'status' => 'active',
                'usage_count' => 23,
                'usage_limit' => 30,
                'applicable_products' => ['Bluetooth Speakers'],
                'target_audience' => 'all_customers',
                'created_at' => now()->subDays(5)
            ]
        ];

        // Apply filters
        if ($request->has('status') && $request->status) {
            $promotions = array_filter($promotions, function($promotion) use ($request) {
                return $promotion['status'] === $request->status;
            });
        }

        if ($request->has('type') && $request->type) {
            $promotions = array_filter($promotions, function($promotion) use ($request) {
                return $promotion['type'] === $request->type;
            });
        }

        // Promotion statistics
        $promotionStats = [
            'total_promotions' => count($promotions),
            'active_promotions' => count(array_filter($promotions, fn($p) => $p['status'] === 'active')),
            'total_usage' => array_sum(array_column($promotions, 'usage_count')),
            'total_savings' => 15678.90,
            'conversion_rate' => 18.5,
            'avg_discount' => 22.5
        ];

        return view('manufacturer.promotions.index', compact('promotions', 'promotionStats'));
    }

    public function create()
    {
        return view('manufacturer.promotions.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'applicable_products' => 'nullable|array',
            'target_audience' => 'required|in:all_customers,new_customers,business_customers,vip_customers'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would save to database
        $promotion = [
            'id' => rand(100, 999),
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'discount_value' => $request->discount_value,
            'min_order_amount' => $request->min_order_amount ?? 0,
            'max_discount' => $request->max_discount,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'active',
            'usage_count' => 0,
            'usage_limit' => $request->usage_limit,
            'applicable_products' => $request->applicable_products ?? [],
            'target_audience' => $request->target_audience,
            'created_at' => now()
        ];

        return response()->json([
            'success' => true,
            'message' => 'Promotion created successfully',
            'promotion' => $promotion
        ]);
    }

    public function show($id)
    {
        // Sample promotion details with analytics
        $promotion = [
            'id' => $id,
            'title' => 'Summer Electronics Sale',
            'description' => '25% off on all wireless headphones and smart watches',
            'type' => 'percentage',
            'discount_value' => 25,
            'min_order_amount' => 100.00,
            'max_discount' => 500.00,
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(25),
            'status' => 'active',
            'usage_count' => 45,
            'usage_limit' => 100,
            'applicable_products' => ['Wireless Headphones', 'Smart Watches'],
            'target_audience' => 'all_customers',
            'created_at' => now()->subDays(10),
            'analytics' => [
                'total_orders' => 45,
                'total_revenue' => 12500.00,
                'total_savings' => 3125.00,
                'conversion_rate' => 18.5,
                'avg_order_value' => 277.78,
                'daily_usage' => [
                    ['date' => now()->subDays(4)->format('M d'), 'count' => 8],
                    ['date' => now()->subDays(3)->format('M d'), 'count' => 12],
                    ['date' => now()->subDays(2)->format('M d'), 'count' => 15],
                    ['date' => now()->subDays(1)->format('M d'), 'count' => 10],
                ]
            ]
        ];

        return response()->json($promotion);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'applicable_products' => 'nullable|array',
            'target_audience' => 'required|in:all_customers,new_customers,business_customers,vip_customers'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Here you would update in database
        return response()->json([
            'success' => true,
            'message' => 'Promotion updated successfully'
        ]);
    }

    public function destroy($id)
    {
        // Here you would delete from database
        return response()->json([
            'success' => true,
            'message' => 'Promotion deleted successfully'
        ]);
    }

    public function activate($id)
    {
        // Here you would activate the promotion
        return response()->json([
            'success' => true,
            'message' => 'Promotion activated successfully'
        ]);
    }

    public function deactivate($id)
    {
        // Here you would deactivate the promotion
        return response()->json([
            'success' => true,
            'message' => 'Promotion deactivated successfully'
        ]);
    }

    public function duplicate($id)
    {
        // Here you would duplicate the promotion
        return response()->json([
            'success' => true,
            'message' => 'Promotion duplicated successfully',
            'new_promotion_id' => rand(100, 999)
        ]);
    }

    public function getPromotionStats(Request $request)
    {
        $period = $request->get('period', '30');

        $stats = [
            'performance_overview' => [
                'total_promotions' => rand(10, 25),
                'active_promotions' => rand(5, 15),
                'total_usage' => rand(100, 500),
                'total_savings' => rand(5000, 25000),
                'conversion_rate' => rand(15, 30),
                'avg_discount' => rand(15, 35)
            ],
            'promotion_types' => [
                'percentage' => rand(60, 80),
                'fixed' => rand(20, 40)
            ],
            'target_audience_performance' => [
                'all_customers' => ['usage' => rand(100, 200), 'conversion' => rand(15, 25)],
                'new_customers' => ['usage' => rand(50, 100), 'conversion' => rand(20, 35)],
                'business_customers' => ['usage' => rand(30, 80), 'conversion' => rand(25, 40)],
                'vip_customers' => ['usage' => rand(20, 50), 'conversion' => rand(30, 45)]
            ],
            'monthly_trend' => $this->generateMonthlyTrend($period)
        ];

        return response()->json($stats);
    }

    private function generateMonthlyTrend($period)
    {
        $trend = [];
        $months = min($period / 30, 12);

        for ($i = $months; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $trend[] = [
                'month' => $date->format('M Y'),
                'promotions_created' => rand(2, 8),
                'total_usage' => rand(50, 200),
                'revenue_impact' => rand(2000, 10000),
                'conversion_rate' => rand(15, 30)
            ];
        }

        return $trend;
    }

    public function exportPromotions(Request $request)
    {
        $format = $request->get('format', 'excel');
        $status = $request->get('status', 'all');
        $dateRange = $request->get('date_range', '30');

        return response()->json([
            'success' => true,
            'message' => 'Promotions exported successfully',
            'download_url' => '#',
            'filters' => [
                'format' => $format,
                'status' => $status,
                'date_range' => $dateRange
            ]
        ]);
    }

    public function generateCouponCode()
    {
        // Generate a random coupon code
        $code = 'PROMO' . strtoupper(substr(md5(uniqid()), 0, 6));
        
        return response()->json([
            'success' => true,
            'coupon_code' => $code
        ]);
    }

    public function validateCoupon(Request $request)
    {
        $code = $request->get('code');
        $orderAmount = $request->get('order_amount', 0);

        // Sample validation logic
        $isValid = strlen($code) >= 6;
        $discount = $isValid ? rand(10, 50) : 0;

        return response()->json([
            'valid' => $isValid,
            'discount_amount' => $discount,
            'message' => $isValid ? 'Coupon is valid' : 'Invalid coupon code'
        ]);
    }
}