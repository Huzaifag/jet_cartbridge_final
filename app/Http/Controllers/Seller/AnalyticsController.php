<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $seller = auth()->user()->seller;
        $period = $request->get('period', '30'); // days
        $startDate = Carbon::now()->subDays($period);

        // Revenue Trends
        $revenueTrends = Order::where('seller_id', $seller->id)
            ->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, SUM(total) as revenue, COUNT(*) as orders')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Best-selling Products
        $bestSellingProducts = Product::where('seller_id', $seller->id)
            ->withCount(['orderItems as total_sold' => function($query) use ($startDate) {
                $query->whereHas('order', function($q) use ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                });
            }])
            ->withSum(['orderItems as total_revenue' => function($query) use ($startDate) {
                $query->whereHas('order', function($q) use ($startDate) {
                    $q->where('created_at', '>=', $startDate);
                });
            }], DB::raw('quantity * price'))
            ->having('total_sold', '>', 0)
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->get();

        // Peak Seasons Analysis (Monthly)
        $peakSeasons = Order::where('seller_id', $seller->id)
            ->where('created_at', '>=', Carbon::now()->subYear())
            ->selectRaw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(*) as orders, SUM(total) as revenue')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Buyer Behavior
        $buyerBehavior = User::whereHas('orders', function($q) use ($seller, $startDate) {
            $q->where('seller_id', $seller->id)
              ->where('created_at', '>=', $startDate);
        })
        ->withCount(['orders as total_orders' => function($query) use ($seller, $startDate) {
            $query->where('seller_id', $seller->id)
                  ->where('created_at', '>=', $startDate);
        }])
        ->withSum(['orders as total_spent' => function($query) use ($seller, $startDate) {
            $query->where('seller_id', $seller->id)
                  ->where('created_at', '>=', $startDate);
        }], 'total')
        ->orderBy('total_spent', 'desc')
        ->take(10)
        ->get();

        // Review Engagement
        $reviewEngagement = Review::whereHas('product', function($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })
        ->where('created_at', '>=', $startDate)
        ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as total_reviews')
        ->first();

        $reviewsByRating = Review::whereHas('product', function($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })
        ->where('created_at', '>=', $startDate)
        ->selectRaw('rating, COUNT(*) as count')
        ->groupBy('rating')
        ->orderBy('rating', 'desc')
        ->get();

        // Summary Stats
        $totalRevenue = Order::where('seller_id', $seller->id)
            ->where('created_at', '>=', $startDate)
            ->sum('total');

        $totalOrders = Order::where('seller_id', $seller->id)
            ->where('created_at', '>=', $startDate)
            ->count();

        $totalCustomers = User::whereHas('orders', function($q) use ($seller, $startDate) {
            $q->where('seller_id', $seller->id)
              ->where('created_at', '>=', $startDate);
        })->count();

        $avgOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('seller.analytics.index', compact(
            'revenueTrends',
            'bestSellingProducts',
            'peakSeasons',
            'buyerBehavior',
            'reviewEngagement',
            'reviewsByRating',
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'avgOrderValue',
            'period'
        ));
    }
}
