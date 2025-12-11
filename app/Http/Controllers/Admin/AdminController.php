<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $dashboardData = [];

        // Get user's primary role and related model
        $roleData = $this->getUserRoleData($user);
        
        if (!$roleData) {
            return redirect()->route('login')->with('error', 'Access denied. Please contact administrator.');
        }

        // Get dashboard data based on user's role
        switch ($roleData['role']) {
            case 'seller':
                $dashboardData = $this->getSellerDashboardData($roleData['model'], $request);
                break;
            case 'accountant':
                $dashboardData = $this->getAccountantDashboardData($roleData['model']);
                break;
            case 'manufacturer':
                $dashboardData = $this->getManufacturerDashboardData($roleData['model'], $request);
                break;
            case 'salesman':
                $dashboardData = $this->getSalesmanDashboardData($roleData['model']);
                break;
            case 'warehouse':
                $dashboardData = $this->getWarehouseDashboardData($roleData['model']);
                break;
            case 'deliveryman':
                $dashboardData = $this->getDeliverymanDashboardData($roleData['model']);
                break;
            default:
                $dashboardData = $this->getDefaultDashboardData($user);
        }

        $dashboardData['userRole'] = $roleData['role'];
        $dashboardData['userModel'] = $roleData['model'];

        return view('admin.dashboard.index', $dashboardData);
    }

    private function getUserRoleData($user)
    {
        // Check user's roles and return the primary role with its model
        if ($user->seller) {
            return ['role' => 'seller', 'model' => $user->seller];
        }
        
        if ($user->accountant) {
            return ['role' => 'accountant', 'model' => $user->accountant];
        }
        
        if ($user->manufacturer) {
            return ['role' => 'manufacturer', 'model' => $user->manufacturer];
        }
        
        if ($user->salesman) {
            return ['role' => 'salesman', 'model' => $user->salesman];
        }
        
        if ($user->warehouse) {
            return ['role' => 'warehouse', 'model' => $user->warehouse];
        }
        
        if ($user->deliveryman) {
            return ['role' => 'deliveryman', 'model' => $user->deliveryman];
        }

        // Default customer role
        return ['role' => 'customer', 'model' => $user];
    }

    private function getSellerDashboardData($seller, $request)
    {
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

        // New Customers
        $newCustomers = Order::where('seller_id', $seller->id)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->distinct('customer_id')
            ->count('customer_id');

        return [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'activeProducts' => $activeProducts,
            'newCustomers' => $newCustomers,
            'range' => $range
        ];
    }

    private function getAccountantDashboardData($accountant)
    {
        $ordersNeedingInvoice = $accountant->seller->orders()
            ->where('status', 'Confirmed')
            ->whereNull('invoice')
            ->with(['customer', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total_orders' => $accountant->seller->orders()->count(),
            'invoiced_orders' => $accountant->seller->orders()->whereNotNull('invoice')->count(),
            'pending_invoices' => $accountant->seller->orders()->where('status', 'Confirmed')->whereNull('invoice')->count(),
            'total_revenue' => $accountant->seller->orders()->whereNotNull('invoice')->sum('total'),
        ];

        return [
            'ordersNeedingInvoice' => $ordersNeedingInvoice,
            'stats' => $stats
        ];
    }

    private function getManufacturerDashboardData($manufacturer, $request)
    {
        // Similar to seller but for manufacturer
        $range = $request->get('range', 'today');
        $startDate = $this->getStartDate($range);
        $endDate = Carbon::now();

        $totalProducts = Product::where('manufacturer_id', $manufacturer->id)->count();
        $activeProducts = Product::where('manufacturer_id', $manufacturer->id)
            ->where('status', 'active')
            ->count();

        return [
            'totalProducts' => $totalProducts,
            'activeProducts' => $activeProducts,
            'range' => $range
        ];
    }

    private function getSalesmanDashboardData($salesman)
    {
        // Salesman specific data
        return [
            'assigned_leads' => 0, // Implement based on your leads system
            'converted_leads' => 0,
        ];
    }

    private function getWarehouseDashboardData($warehouse)
    {
        // Warehouse specific data
        return [
            'pending_shipments' => 0, // Implement based on your warehouse system
            'completed_shipments' => 0,
        ];
    }

    private function getDeliverymanDashboardData($deliveryman)
    {
        // Deliveryman specific data
        return [
            'pending_deliveries' => 0, // Implement based on your delivery system
            'completed_deliveries' => 0,
        ];
    }

    private function getDefaultDashboardData($user)
    {
        return [
            'message' => 'Welcome to your dashboard!'
        ];
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
                return Carbon::create(2000, 1, 1);
            default:
                return Carbon::today();
        }
    }
}