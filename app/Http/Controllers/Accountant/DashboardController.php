<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $accountant = Auth::user()->accountant;

        // Get orders that need invoicing (confirmed but no invoice yet)
        $ordersNeedingInvoice = $accountant->seller->orders()
            ->where('status', 'Confirmed')
            ->whereNull('invoice')
            ->with(['customer', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        // Stats
        $stats = [
            'total_orders' => $accountant->seller->orders()->count(),
            'invoiced_orders' => $accountant->seller->orders()->whereNotNull('invoice')->count(),
            'pending_invoices' => $accountant->seller->orders()->where('status', 'Confirmed')->whereNull('invoice')->count(),
            'total_revenue' => $accountant->seller->orders()->whereNotNull('invoice')->sum('total'),
        ];

        return view('accountant.dashboard.index', compact('ordersNeedingInvoice', 'stats'));
    }
}
