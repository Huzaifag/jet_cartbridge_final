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
        // $this->authorize('viewAny', Order::class);

        $orders = Auth::user()
            ->salesman
            ->seller
            ->orders()
            ->where('status', 'Order Placed')
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
        // $this->authorize('confirmAsSalesman', $order);

        // Validate current stage
        $currentStatus = $order->statuses()->where('stage', 'order_placed')->first();
        if (!$currentStatus || $currentStatus->status !== 'completed') {
            return redirect()->back()->with('error', 'Order is not in the correct stage for confirmation.');
        }

        $order->status = 'Confirmed';
        $order->save();

        // Audit logging
        Log::info('Order confirmed by salesman', [
            'order_id' => $order->id,
            'salesman_id' => Auth::id(),
            'timestamp' => now(),
        ]);

        // Fetch all stages in correct order
        $stageOrder = [
            'order_placed',
            'with_accountant',
            'invoice_stage',
            'in_production',
            'delivery',
        ];

        $currentStage = 'order_placed';
        $currentIndex = array_search($currentStage, $stageOrder);

        if ($currentIndex === false || $currentIndex === count($stageOrder) - 1) {
            return redirect()->back()->with('error', 'Already in final stage or invalid stage.');
        }

        // Mark current stage as completed
        OrderStatus::where('order_id', $order->id)
            ->where('stage', $currentStage)
            ->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

        // Move next stage to in_progress
        $nextStage = $stageOrder[$currentIndex + 1];
        OrderStatus::where('order_id', $order->id)
            ->where('stage', $nextStage)
            ->update([
                'status' => 'in_progress',
                'started_at' => now(),
            ]);

        return redirect()->back()->with('success', 'Order confirmed successfully');
    }
}
