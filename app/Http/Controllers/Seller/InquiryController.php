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

    public function showAssignForm($inquiryId)
    {
        $inquiry = UserInquiry::with(['product', 'customer', 'contact'])->findOrFail($inquiryId);
        
        // Check if inquiry belongs to this seller
        if ($inquiry->seller_id !== auth()->user()->seller->id) {
            return redirect()->route('seller.inquiries.index')->with('error', 'Unauthorized action.');
        }

        return view('seller.inquiries.assign', compact('inquiry'));
    }

    public function assignToSalesman(Request $request, $inquiryId)
    {
        $validated = $request->validate([
            'salesman_id' => 'required|exists:salesmen,id',
            'notes' => 'nullable|string|max:500',
        ]);

        $inquiry = UserInquiry::findOrFail($inquiryId);
        
        // Check if inquiry belongs to this seller
        if ($inquiry->seller_id !== auth()->user()->seller->id) {
            return back()->with('error', 'Unauthorized action.');
        }

        // Check if salesman belongs to this seller
        $salesman = auth()->user()->seller->salesmen()->findOrFail($validated['salesman_id']);

        // Find or create the lead for this inquiry
        $lead = \App\Models\Lead::where('inquiry_id', $inquiry->id)->first();

        if ($lead) {
            // Update existing lead
            $lead->update([
                'salesman_id' => $validated['salesman_id'],
                'assigned_at' => now(),
                'split_notes' => $validated['notes'] ?? null,
                'status' => 'pending',
                'priority' => 'high',
            ]);
        } else {
            // This shouldn't happen as leads are auto-created, but just in case
            $lead = \App\Models\Lead::create([
                'inquiry_id' => $inquiry->id,
                'seller_id' => $inquiry->seller_id,
                'buyer_id' => $inquiry->customer_id,
                'buyer_name' => $inquiry->contact->name ?? $inquiry->customer->name,
                'buyer_phone' => $inquiry->contact->phone ?? null,
                'email' => $inquiry->contact->email ?? $inquiry->customer->email,
                'product_id' => $inquiry->product_id,
                'message' => $inquiry->message ?? 'B2B Inquiry',
                'quantity' => $inquiry->quantity,
                'target_price' => $inquiry->target_price,
                'salesman_id' => $validated['salesman_id'],
                'assigned_at' => now(),
                'split_notes' => $validated['notes'] ?? null,
                'status' => 'pending',
                'priority' => 'high',
            ]);
        }

        return back()->with('success', 'Inquiry assigned to ' . $salesman->user->name . ' successfully!');
    }
}
