<?php

namespace App\Http\Controllers\Deliveryman;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDelivery;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryManController extends Controller
{
    /**
     * Display the deliveryman dashboard.
     */
    public function index()
    {
        $deliveryman = Auth::user()->deliveryman;

        // Get orders assigned to this deliveryman (assuming orders have delivery_person_id)
        $assignedOrders = Order::where('delivery_person_id', $deliveryman->id)
            ->with(['customer', 'orderItems.product'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total_assigned' => Order::where('delivery_person_id', $deliveryman->id)->count(),
            'delivered' => Order::where('delivery_person_id', $deliveryman->id)->where('status', 'Delivered')->count(),
            'pending' => Order::where('delivery_person_id', $deliveryman->id)->where('status', 'Dispatched')->count(),
        ];

        return view('deliveryman.dashboard.index', compact('assignedOrders', 'stats'));
    }

    /**
     * Display a listing of assigned orders.
     */
    public function orders(Request $request)
    {
        // $this->authorize('viewAny', Order::class);

        $deliveryman = Auth::user()->deliveryman;

        $query = Order::where('delivery_person_id', $deliveryman->id)
            ->with(['customer', 'orderItems.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('deliveryman.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // $this->authorize('view', $order);

        $order->load(['customer', 'orderItems.product', 'seller', 'statuses']);

        return view('deliveryman.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the delivery details.
     */
    public function edit(Order $order)
    {
        // $this->authorize('deliver', $order);

        $order->load(['customer', 'orderItems.product', 'seller', 'statuses']);

        return view('deliveryman.orders.edit', compact('order'));
    }

    /**
     * Mark the order as delivered.
     */
    public function deliver(Request $request, Order $order)
    {
        // $this->authorize('deliver', $order);

        // Validate current stage
        $currentStatus = $order->statuses()->where('stage', 'delivery')->first();
        if (!$currentStatus || $currentStatus->status !== 'in_progress') {
            return redirect()->back()->with('error', 'Order is not in the correct stage for delivery.');
        }

        $request->validate([
            'delivery_date' => 'required|date',
            'delivery_time' => 'required',
            'proof_of_delivery' => 'required|image|max:2048',
            'delivery_notes' => 'nullable|string|max:500',
        ]);

        // Update order status to 'Delivered'
        $order->update(['status' => 'Delivered']);

        // Create or update order delivery record
        $proofPath = $request->file('proof_of_delivery')->store('delivery-proofs', 'public');

        OrderDelivery::updateOrCreate(
            ['order_id' => $order->id],
            [
                'customer_id' => $order->customer_id,
                'delivery_date' => $request->delivery_date,
                'delivery_time' => $request->delivery_time,
                'proof_of_delivery' => $proofPath,
                'delivery_notes' => $request->delivery_notes,
            ]
        );

        // Audit logging
        \Illuminate\Support\Facades\Log::info('Order delivered by deliveryman', [
            'order_id' => $order->id,
            'deliveryman_id' => Auth::id(),
            'delivery_date' => $request->delivery_date,
            'delivery_time' => $request->delivery_time,
            'timestamp' => now(),
        ]);

        // Update order status stages
        $stageOrder = [
            'order_placed',
            'with_accountant',
            'invoice_stage',
            'in_production',
            'delivery',
        ];

        $currentStage = 'delivery';
        $currentIndex = array_search($currentStage, $stageOrder);

        if ($currentIndex !== false) {
            // Mark delivery stage as completed
            OrderStatus::where('order_id', $order->id)
                ->where('stage', $currentStage)
                ->update([
                    'status' => 'completed',
                    'completed_at' => now(),
                ]);
        }

        return redirect()->route('deliveryman.orders.show', $order)
            ->with('success', 'Order marked as delivered successfully.');
    }
}
