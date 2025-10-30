<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WarehouseOrdersController extends Controller
{
  public function index()
  {
    $orders = Auth::user()
      ->warehouse
      ->seller
      ->orders()
      ->whereNotNull('invoice')
      ->orderBy('id', 'desc')
      ->paginate(10);

    return view('warehouse.orders.index', compact('orders'));
  }

  public function show(int $id)
  {
    $order = Order::findOrFail($id);
    // dd($order->orderItems->toArray());

    return view('warehouse.orders.show', compact('order'));
  }

  public function edit(int $id)
  {
    $order = Order::findOrFail($id);
    return view('warehouse.orders.edit', compact('order'));
  }

  public function dispatch(Request $request, $id)
  {
    // Validate form inputs
    $validated = $request->validate([
      'courier_name' => 'required|string|max:255',
      'tracking_number' => 'required|string|max:255|unique:orders,tracking_number',
      'dispatch_details' => 'nullable|string|max:1000',
      'dispatch_video' => 'required|file|mimes:mp4,mov,avi|max:20480', // max 20MB
    ]);

    // Find order
    $order = Order::findOrFail($id);

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
      'status' => 'dispatched',
      'dispatched_at' => Carbon::now(),
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

    // Optionally send notification or email to customer here
    // e.g. Mail::to($order->customer->email)->send(new OrderDispatchedMail($order));

    return redirect()
      ->route('warehouse-orders.show', $order->id)
      ->with('success', 'Order has been successfully dispatched!');
  }
}
