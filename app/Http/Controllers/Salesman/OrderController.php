<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        // Get orders that are in salesman_review stage
        $orders = Auth::user()
            ->salesman
            ->seller
            ->orders()
            ->whereHas('statuses', function($query) {
                $query->where('stage', 'salesman_review')
                      ->where('status', 'in_progress');
            })
            ->paginate(10);

        return view('salesman.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::findOrFail($id);
        // $this->authorize('view', $order);

        return view('salesman.orders.show', compact('order'));
    }

    public function confirm(int $id)
    {
        $order = Order::findOrFail($id);

        // Validate current stage - should be in salesman_review
        $currentStatus = $order->statuses()->where('stage', 'salesman_review')->first();
        if (!$currentStatus || $currentStatus->status !== 'in_progress') {
            return redirect()->back()->with('error', 'Order is not in salesman review stage.');
        }

        // Update order status
        $order->status = 'Confirmed by Salesman';
        $order->save();

        // Audit logging
        Log::info('Order confirmed by salesman', [
            'order_id' => $order->id,
            'salesman_id' => Auth::id(),
            'timestamp' => now(),
        ]);

        // Mark salesman_review as completed
        OrderStatus::where('order_id', $order->id)
            ->where('stage', 'salesman_review')
            ->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

        // Move to accountant_billing stage
        OrderStatus::where('order_id', $order->id)
            ->where('stage', 'accountant_billing')
            ->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Order confirmed and sent to Accountant for billing.');
    }
}
