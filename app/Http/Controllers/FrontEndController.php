<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Seller;
use App\Models\UserInquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{
    public function index()
    {
        // Fetch all active products with seller and creator
        $featuredProducts = Product::where('status', 'active')
            ->with('seller')
            ->latest()
            ->get();

        $sellers = Seller::with('products')->where('status', 'approved')->latest()->paginate(6);



        return view('frontend.pages.index', compact('featuredProducts', 'sellers'));
    }

    public function showProduct($slug)
    {
        $product = Product::with('seller')->where('slug', $slug)->where('status', 'active')->firstOrFail();
        $reviews = $product->reviews()->with('user')->latest()->get();
        return view('frontend.pages.product-details', compact('product', 'reviews'));
    }

    public function showInquiryForm($slug)
    {
        try {
            $product = Product::with('seller')->where('slug', $slug)->firstOrFail();
            $seller = $product->seller;
            $userContacts = auth()->user() ? auth()->user()->contacts : [];
            return view('frontend.pages.inquiry-form', compact('product', 'seller', 'userContacts'));
        } catch (\Exception $e) {
            Log::error('Error fetching product for inquiry form: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Product not found or an error occurred.');
        }
    }


    public function submitInquiry(Request $request)
    {

        $validated = $request->validate([
            'contact_id'   => 'required|exists:user_contacts,id',
            'product_id'   => 'required|exists:products,id',
            'quantity'     => 'required|integer|min:1',
            'target_price' => 'nullable|numeric|min:0',
            'destination'  => 'nullable|string|max:255',
            'deadline'     => 'nullable|date',
            'message'      => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if (auth()->user()->seller && $product->seller_id === auth()->user()->seller->id) {
            return redirect()->back()->with('error', 'You cannot send an inquiry to your own product.');
        }
        $seller = $product->seller;

        $inquiry = UserInquiry::create(array_merge($validated, [
            'seller_id'    => $seller->id,
            'customer_id'  => auth()->id(),
        ]));

        return redirect()
            ->back()
            ->with('success', 'Your inquiry has been submitted successfully!');
    }

    public function showTrackOrderForm()
    {
        $orders = auth()->user() ? auth()->user()->orders()->with(['statuses', 'customer', 'products', 'seller'])->latest()->get() : [];

        // dd($orders->toArray());

        return view('frontend.pages.track-order', compact('orders'));
    }

    // public function seller($slug)
    // {
    //     try {
    //         $seller = Seller::with('products')->where('slug', $slug)->where('status', 'approved')->firstOrFail();
    //         $products = $seller->products;
    //         // dd($products->toArray());

    //         return view('frontend.seller', compact('seller', 'products'));
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching seller or products: ' . $e->getMessage());
    //         return redirect()->route('home')->with('error', 'Seller not found or an error occurred.');
    //     }
    // }
}
