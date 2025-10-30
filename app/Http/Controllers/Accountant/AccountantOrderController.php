<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AccountantOrderController extends Controller
{


  public function index()
  {
    $orders = Auth::user()
      ->accountant
      ->seller
      ->orders()
      ->where('status', 'Confirmed')
      ->orderBy('id', 'desc')
      ->paginate(10);

    return view('accountant.orders.index', compact('orders'));
  }


  public function show(int $id)

  {
    $order = Order::findOrFail($id);
    // dd($order->orderItems->toArray());

    return view('accountant.orders.show', compact('order'));
  }

  public function confirm($id)
  {
    $order = Order::with('orderItems.product')->findOrFail($id);
    return view('accountant.orders.invoicing', compact('order'));
  }


  public function saveInvoice($id)
  {
    // 1️⃣ Fetch order with items and products
    $order = Order::with('orderItems.product')->findOrFail($id);

    // Calculate total if not present
    $totalAmount = $order->orderItems->sum(function ($item) {
      return $item->price * $item->quantity;
    });

    $data = [
      'order' => $order,
      'total_amount' => $totalAmount,
    ];

    // 2️⃣ Generate the PDF
    $pdf = Pdf::loadView('accountant.orders.invoice', $data)
      ->setPaper('a4', 'portrait');

    $filename = 'invoice-order-' . $order->id . '.pdf';

    // ⚠️ Fix: use ->toDateTimeString() instead of ->toDateTime()
    $order->invoice = $filename;
    $order->invoice_date = Carbon::now()->toDateTimeString();
    $order->save();

    



    // 3️⃣ Order stage updates
    $stageOrder = [
      'order_placed',
      'with_accountant',
      'invoice_stage',
      'in_production',
      'delivery',
    ];

    $currentStage = 'with_accountant';
    $currentIndex = array_search($currentStage, $stageOrder);

    if ($currentIndex === false || $currentIndex >= count($stageOrder) - 1) {
      return response()->json(['message' => 'Already in final stage or invalid stage.'], 400);
    }

    // Mark current stage as completed
    OrderStatus::where('order_id', $order->id)
      ->where('stage', $currentStage)
      ->update([
        'status' => 'completed',
        'completed_at' => now(),
      ]);

    // ✅ Fix stage logic:
    // Next stage becomes "completed"
    $nextStage = $stageOrder[$currentIndex + 1];
    OrderStatus::where('order_id', $order->id)
      ->where('stage', $nextStage)
      ->update([
        'status' => 'completed',
        'completed_at' => now(),
      ]);

    // Next-to-next stage becomes "in_progress" (if exists)
    if (isset($stageOrder[$currentIndex + 2])) {
      $nextInProgress = $stageOrder[$currentIndex + 2];
      OrderStatus::where('order_id', $order->id)
        ->where('stage', $nextInProgress)
        ->update([
          'status' => 'in_progress',
          'started_at' => now(),
        ]);
    }

    // 4️⃣ Save the PDF to storage
    Storage::put('public/invoices/' . $filename, $pdf->output());

    // 5️⃣ Return the PDF for download
    return $pdf->download($filename);
  }
}
