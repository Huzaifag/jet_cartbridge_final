<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use App\Models\UserInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index()
    {
        $inquiries = auth()->user()->seller->customerInquiries()->with(['product', 'customer', 'contact'])->latest()->paginate(10);
        return view('seller.inquiries.index', compact('inquiries'));
    }

    public function createResponse(UserInquiry $inquiry)
    {
        // Logic to show a form for creating a response/quote to the inquiry
        return view('seller.inquiries.response', compact('inquiry'));
    }

    public function createBulkOrder($id)
    {
        $inquiry = UserInquiry::with('product')->findOrFail($id);
        // dd($inquiry->toArray());

        return view('seller.inquiries.bulk-order-create', compact('inquiry'));
    }

    public function storeBulkOrder(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'inquiry_id'    => 'required|exists:user_inquiries,id',
            'product_id'    => 'required|exists:products,id',
            'customer_id'   => 'required|exists:users,id',
            'quantity'      => 'required|integer|min:1',
            'unit_price'    => 'required|numeric|min:0',
            'shipping_cost' => 'nullable|numeric|min:0',
            'destination'   => 'required|string|max:255',
            'delivery_date' => 'nullable|date',
            'payment_terms' => 'required|string|max:255',
            'order_notes'   => 'nullable|string',
        ]);

        // Calculate totals
        $subtotal = $validated['quantity'] * $validated['unit_price'];
        $total = $subtotal + ($validated['shipping_cost'] ?? 0);

        // Create order
        $order = BulkOrder::create([
            ...$validated,
            'seller_id' => auth()->id(), // the seller creating the order
            'total'     => $total,
            'status'    => 'pending',
        ]);

        // Redirect to order details page
        return redirect()
            ->back()
            ->with('success', 'Bulk order created successfully!');
    }


    public function bulkIndex()
    {
        $bulkOrders = BulkOrder::with(['product', 'customer'])->latest()->paginate(10);
        return view('seller.bulk-orders.index', compact('bulkOrders'));
    }

    public function bulkShow(BulkOrder $bulkOrder)
    {
        return view('seller.bulk-orders.show', compact('bulkOrder'));
    }
}
