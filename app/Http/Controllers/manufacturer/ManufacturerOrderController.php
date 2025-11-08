<?php

namespace App\Http\Controllers\manufacturer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class ManufacturerOrderController extends Controller
{
    public function index(Request $request)
    {
        $manufacturer = auth()->user()->manufacturer;

        $query = Order::where('manufacturer_id', $manufacturer->id)
            ->with(['customer', 'orderItems.product']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->latest()->paginate(15);

        return view('manufacturer.order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['customer', 'orderItems.product', 'address']);

        return view('manufacturer.order.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'notes' => 'nullable|string'
        ]);

        $order->update($validated);

        return redirect()
            ->route('manufacturer.orders.show', $order)
            ->with('success', 'Order updated successfully');
    }

    public function tracking_view()
    {
        $manufacturer = auth()->user()->manufacturer;
        $orders = Order::where('manufacturer_id', $manufacturer->id)
            ->with(['customer', 'orderItems'])
            ->latest()
            ->paginate(20);

        return view('manufacturer.order.tracking', compact('orders'));
    }
}
