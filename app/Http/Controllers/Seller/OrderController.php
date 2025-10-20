<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $seller_id = auth()->user()->seller->id;

        // Start query
        $query = Order::where('seller_id', $seller_id);

        // 🔎 Search by Order ID or Customer ID
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                    ->orWhere('customer_id', 'like', "%{$search}%");
            });
        }

        // 🔎 Filter by payment status
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        // 🔎 Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        // Fetch filtered orders (with pagination)
        $orders = $query->latest()->paginate(10)->withQueryString();

        // Stats (calculated on ALL filtered orders, not just the current page)
        $totalOrders = $query->count();
        $totalRevenue = $query->sum('total');
        $pendingCount = (clone $query)->where('payment_status', 'pending')->count();

        return view('seller.order.index', compact(
            'orders',
            'totalOrders',
            'totalRevenue',
            'pendingCount'
        ));
    }

    public function tracking_view()
    {
        return view('seller.order.track-index');
    }

    public function show(Order $order)
    {   
        return view('seller.order.show', compact('order'));
    }
}
