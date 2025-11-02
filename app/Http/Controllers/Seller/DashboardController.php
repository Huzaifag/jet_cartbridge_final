<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $seller = auth()->user()->seller;

        // Get date range from request or default to today
        $range = $request->get('range', 'today');
        $startDate = $this->getStartDate($range);
        $endDate = Carbon::now();

        // Total Sales
        $totalSales = Order::where('seller_id', $seller->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->where('payment_status', 'paid')
            ->sum('total');

        // Total Orders
        $totalOrders = Order::where('seller_id', $seller->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Active Products
        $activeProducts = Product::where('seller_id', $seller->id)
            ->where('status', 'active')
            ->count();

        // New Customers (unique customers who placed orders in the period)
        $newCustomers = Order::where('seller_id', $seller->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct('customer_id')
            ->count('customer_id');

        // Calculate percentage changes (comparing with previous period)
        $previousPeriod = $this->getPreviousPeriod($range);
        $salesChange = $this->calculateChange(
            Order::where('seller_id', $seller->id)
                ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
                ->where('payment_status', 'paid')
                ->sum('total'),
            $totalSales
        );

        $ordersChange = $this->calculateChange(
            Order::where('seller_id', $seller->id)
                ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
                ->count(),
            $totalOrders
        );

        $productsChange = $this->calculateChange(
            Product::where('seller_id', $seller->id)
                ->where('created_at', '<=', $previousPeriod['end'])
                ->where('status', 'active')
                ->count(),
            $activeProducts
        );

        $customersChange = $this->calculateChange(
            Order::where('seller_id', $seller->id)
                ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
                ->distinct('customer_id')
                ->count('customer_id'),
            $newCustomers
        );

        // Top Selling Products
        $topProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.seller_id', $seller->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->where('orders.payment_status', 'paid')
            ->select(
                'products.name',
                'products.images',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.images')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        // Recent Activities (last 10 activities)
        $recentActivities = collect();

        // Recent orders
        $recentOrders = Order::where('seller_id', $seller->id)
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'type' => 'order',
                    'title' => "New order #{$order->id} received",
                    'time' => $order->created_at->diffForHumans(),
                    'icon' => 'fas fa-shopping-cart',
                    'icon_bg' => 'rgba(40, 167, 69, 0.1)',
                    'icon_color' => '#28a745'
                ];
            });

        // Recent reviews
        $recentReviews = Review::whereHas('product', function ($q) use ($seller) {
            $q->where('seller_id', $seller->id);
        })
            ->with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($review) {
                return [
                    'type' => 'review',
                    'title' => "New {$review->rating}-star review from {$review->user->name}",
                    'time' => $review->created_at->diffForHumans(),
                    'icon' => 'fas fa-star',
                    'icon_bg' => 'rgba(255, 193, 7, 0.1)',
                    'icon_color' => '#ffc107'
                ];
            });

        // Low stock products
        $lowStockProducts = Product::where('seller_id', $seller->id)
            ->where('stock_quantity', '<=', 10)
            ->where('status', 'active')
            ->orderBy('stock_quantity', 'asc')
            ->limit(2)
            ->get()
            ->map(function ($product) {
                return [
                    'type' => 'stock',
                    'title' => "Product '{$product->name}' stock is low ({$product->stock_quantity} remaining)",
                    'time' => 'Recently',
                    'icon' => 'fas fa-box',
                    'icon_bg' => 'rgba(67, 97, 238, 0.1)',
                    'icon_color' => '#4361ee'
                ];
            });

        // Combine and sort activities
        $recentActivities = $recentOrders->concat($recentReviews)->concat($lowStockProducts)
            ->sortByDesc(function ($activity) {
                return Carbon::parse($activity['time']);
            })
            ->take(5);

        // Sales data for chart (last 12 months)
        $salesData = $this->getSalesData($seller->id);

        // Distribution data
        $distributionData = $this->getDistributionData($seller->id, $startDate, $endDate);

        // Revenue trend data (quarterly)
        $revenueData = $this->getRevenueData($seller->id);

        return view('seller.dashboard.index', compact(
            'totalSales',
            'totalOrders',
            'activeProducts',
            'newCustomers',
            'salesChange',
            'ordersChange',
            'productsChange',
            'customersChange',
            'topProducts',
            'recentActivities',
            'salesData',
            'distributionData',
            'revenueData',
            'range'
        ));
    }

    private function getStartDate($range)
    {
        switch ($range) {
            case 'today':
                return Carbon::today();
            case 'week':
                return Carbon::now()->startOfWeek();
            case 'month':
                return Carbon::now()->startOfMonth();
            case 'quarter':
                return Carbon::now()->startOfQuarter();
            case 'year':
                return Carbon::now()->startOfYear();
            case 'all':
                return Carbon::create(2000, 1, 1); // Far past date
            default:
                return Carbon::today();
        }
    }

    private function getPreviousPeriod($range)
    {
        $now = Carbon::now();
        switch ($range) {
            case 'today':
                return [
                    'start' => $now->copy()->subDay(),
                    'end' => $now->copy()->subDay()->endOfDay()
                ];
            case 'week':
                return [
                    'start' => $now->copy()->subWeek()->startOfWeek(),
                    'end' => $now->copy()->subWeek()->endOfWeek()
                ];
            case 'month':
                return [
                    'start' => $now->copy()->subMonth()->startOfMonth(),
                    'end' => $now->copy()->subMonth()->endOfMonth()
                ];
            case 'quarter':
                return [
                    'start' => $now->copy()->subQuarter()->startOfQuarter(),
                    'end' => $now->copy()->subQuarter()->endOfQuarter()
                ];
            case 'year':
                return [
                    'start' => $now->copy()->subYear()->startOfYear(),
                    'end' => $now->copy()->subYear()->endOfYear()
                ];
            default:
                return [
                    'start' => $now->copy()->subDay(),
                    'end' => $now->copy()->subDay()->endOfDay()
                ];
        }
    }

    private function calculateChange($previous, $current)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function getSalesData($sellerId)
    {
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $sales = Order::where('seller_id', $sellerId)
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('payment_status', 'paid')
                ->sum('total');
            $data[] = round($sales, 2);
        }
        return $data;
    }

    private function getDistributionData($sellerId, $startDate, $endDate)
    {
        $categories = ['Food', 'Beverages', 'Desserts', 'Others'];
        $data = [];

        foreach ($categories as $category) {
            $sales = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.seller_id', $sellerId)
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->where('orders.payment_status', 'paid')
                ->where('products.category', $category)
                ->sum(DB::raw('order_items.quantity * order_items.price'));

            $data[] = round($sales, 2);
        }

        return $data;
    }

    private function getRevenueData($sellerId)
    {
        $data = [];
        for ($i = 3; $i >= 0; $i--) {
            $quarter = Carbon::now()->subQuarters($i);
            $start = $quarter->copy()->startOfQuarter();
            $end = $quarter->copy()->endOfQuarter();

            $revenue = Order::where('seller_id', $sellerId)
                ->whereBetween('created_at', [$start, $end])
                ->where('payment_status', 'paid')
                ->sum('total');

            $data[] = round($revenue, 2);
        }
        return $data;
    }
}
