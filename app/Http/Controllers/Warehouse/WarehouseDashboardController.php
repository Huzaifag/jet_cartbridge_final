<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseDashboardController extends Controller
{
    public function index()
    {
        $warehouse = Auth::user()->warehouse;

        // Get orders that are invoiced and ready for dispatch
        $ordersReadyForDispatch = $warehouse->seller->orders()
            ->whereNotNull('invoice')
            ->where('status', 'in_production')
            ->with(['customer', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        // Stats
        $stats = [
            'total_orders' => $warehouse->seller->orders()->count(),
            'dispatched_orders' => $warehouse->seller->orders()->where('status', 'Dispatched')->count(),
            'ready_for_dispatch' => $warehouse->seller->orders()->whereNotNull('invoice')->where('status', 'in_production')->count(),
            'total_revenue' => $warehouse->seller->orders()->where('status', 'Dispatched')->sum('total'),
        ];

        return view('warehouse.dashboard.index', compact('ordersReadyForDispatch', 'stats'));
    }
}
