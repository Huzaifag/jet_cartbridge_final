<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $salesman = Auth::user()->salesman;

        // Get recent orders placed by this salesman
        $recentOrders = $salesman->seller->orders()
            ->with(['customer', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        // Stats
        $stats = [
            'total_orders' => $salesman->seller->orders()->count(),
            'confirmed_orders' => $salesman->seller->orders()->where('status', 'Confirmed')->count(),
            'pending_orders' => $salesman->seller->orders()->where('status', 'order_placed')->count(),
            'total_revenue' => $salesman->seller->orders()->sum('total'),
        ];

        return view('salesman.dashboard.index', compact('recentOrders', 'stats'));
    }
}
