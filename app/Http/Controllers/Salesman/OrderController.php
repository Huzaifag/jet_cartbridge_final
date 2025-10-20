<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()
            ->salesman
            ->seller
            ->orders()   // 👈 Note the parentheses — this returns a query builder
            ->paginate(10);

        return view('salesman.orders.index', compact('orders'));
    }

    public function show(int $id)

    {
        $order = Order::findOrFail($id);
        // dd($order->orderItems->toArray());

        return view('salesman.orders.show', compact('order'));
    }

    public function confirm(int $id)

    {
        $order = Order::findOrFail($id);
        // dd($order->orderItems->toArray());

        $order->status = 'Confirmed';
        $order->save();

        // Fetch all stages in correct order
        $stageOrder = [
            'order_placed',
            'with_accountant',
            'invoice_stage',
            'in_production',
            'delivery',
        ];

        $currentStage = 'order_placed';
        // Find index of current stage
        $currentIndex = array_search($currentStage, $stageOrder);

        if ($currentIndex === false || $currentIndex === count($stageOrder) - 1) {
            return response()->json(['message' => 'Already in final stage or invalid stage.'], 400);
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
