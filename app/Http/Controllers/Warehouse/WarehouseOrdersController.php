<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WarehouseOrdersController extends Controller
{
    public function index()
    {
        // $this->authorize('viewAny', Order::class);

        $orders = Auth::user()
            ->warehouse
            ->seller
            ->orders()
            ->whereNotNull('invoice')
            ->where('status', 'Confirmed')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('warehouse.orders.index', compact('orders'));
    }

    public function show(int $id)
    {
        $order = Order::findOrFail($id);
        // $this->authorize('view', $order);

        return view('warehouse.orders.show', compact('order'));
    }

    public function edit(int $id)
    {
        $order = Order::findOrFail($id);
        // $this->authorize('dispatch', $order);

        // Validate current stage
        $currentStatus = $order->statuses()->where('stage', 'in_production')->first();
        if (!$currentStatus || $currentStatus->status !== 'in_progress') {
            return redirect()->back()->with('error', 'Order is not in the correct stage for dispatch.');
        }

        // Fetch available delivery men for the seller
        $deliveryMen = Auth::user()
            ->warehouse
            ->seller
            ->deliveryMen()
            ->where('status', 'active')
            ->get();

        return view('warehouse.orders.edit', compact('order', 'deliveryMen'));
    }

    public function dispatch(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        // $this->authorize('dispatch', $order);

        // Validate current stage
        $currentStatus = $order->statuses()->where('stage', 'in_production')->first();
        if (!$currentStatus || $currentStatus->status !== 'in_progress') {
            return redirect()->back()->with('error', 'Order is not in the correct stage for dispatch.');
        }

        // Validate form inputs
        $validated = $request->validate([
            'courier_name' => 'required|string|max:255',
            'tracking_number' => 'required|string|max:255|unique:orders,tracking_number',
            'dispatch_details' => 'nullable|string|max:1000',
            'dispatch_video' => 'required|file|mimes:mp4,mov,avi|max:20480', // max 20MB
            'delivery_person_id' => 'nullable|exists:delivery_men,id',
        ]);

        // Handle video upload
        if ($request->hasFile('dispatch_video')) {
            $videoPath = $request->file('dispatch_video')->store('dispatch_videos', 'public');
            $validated['dispatch_video'] = $videoPath;
        }

        // Update order with dispatch details
        $order->update([
            'courier_name' => $validated['courier_name'],
            'tracking_number' => $validated['tracking_number'],
            'dispatch_details' => $validated['dispatch_details'] ?? null,
            'dispatch_video' => $validated['dispatch_video'] ?? null,
            'delivery_person_id' => $validated['delivery_person_id'] ?? null,
            'status' => 'Dispatched',
            'dispatched_at' => Carbon::now(),
        ]);

        // Audit logging
        Log::info('Order dispatched by warehouse', [
            'order_id' => $order->id,
            'warehouse_id' => Auth::id(),
            'courier_name' => $validated['courier_name'],
            'tracking_number' => $validated['tracking_number'],
            'delivery_person_id' => $validated['delivery_person_id'] ?? null,
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

        $currentStage = 'in_production';
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

        return redirect()
            ->route('warehouse.orders.show', $order->id)
            ->with('success', 'Order has been successfully dispatched!');
    }
}
