<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->seller->products();

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->stock_range) {
            $stockRange = explode('-', $request->stock_range);
            $min = $stockRange[0] ?? 0;
            $max = $stockRange[1] ?? PHP_INT_MAX;
            $query->whereBetween('stock_quantity', [(int)$min, (int)$max]);
        }

        if ($request->price_range) {
            $priceRange = explode('-', $request->price_range);
            $min = $priceRange[0] ?? 0;
            $max = $priceRange[1] ?? PHP_INT_MAX;
            $query->whereBetween('price', [(int)$min, (int)$max]);
        }

        $products = $query->latest()->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'b2c_price' => 'required|numeric|min:0',
            'b2c_compare_price' => 'nullable|numeric|min:0',
            'b2b_price' => 'required|numeric|min:0',
            'b2b_moq' => 'required|integer|min:1',
            'stock_quantity' => 'required|integer|min:0',
            'category' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'specifications' => 'nullable|array',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive,out_of_stock',
        ]);

        $imagePaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $newName = uniqid() . '.' . $image->getClientOriginalExtension();

                // Move to public/product-images directory
                $image->move(public_path('product-images'), $newName);

                // Save relative path
                $imagePaths[] = 'products/' . $newName;
            }
        }

        // Parse specifications from JSON string
        $specifications = [];
        if (!empty($validated['specifications'])) {
            $specifications = $validated['specifications'] ?? [];
        }

        // Create product
        $product = Auth::user()->seller->products()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . uniqid(),
            'description' => $validated['description'],
            'b2c_price' => $validated['b2c_price'],
            'b2c_compare_price' => $validated['b2c_compare_price'] ?? null,
            'b2b_price' => $validated['b2b_price'],
            'b2b_moq' => $validated['b2b_moq'],
            'stock_quantity' => $validated['stock_quantity'],
            'category' => $validated['category'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'specifications' => $specifications,
            'images' => $imagePaths,
            'status' => $validated['status'],
            'verification_status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'redirect' => route('seller.products.index')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulkDelete(Request $request)
    {
        if (!Auth::guard('seller')->check()) {
            return redirect()->route('seller.login')->with('error', 'You are not logged in as a seller');
        }

        // if (!Auth::guard('seller')->user()->hasRole('seller')) {
        //     return redirect()->route('seller.login')->with('error', 'You are not a seller');
        // }

        // dd($request->all());

        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        $ids = json_decode($request->selected_ids, true);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No products selected for deletion.');
        }

        // Only delete products that belong to the authenticated seller
        $deleted = auth('seller')->user()->products()->whereIn('id', $ids)->delete();

        if ($deleted > 0) {
            return redirect()->route('seller.products.index')
                ->with('success', $deleted . ' product(s) have been deleted successfully.');
        }

        return redirect()->back()->with('error', 'No products were deleted.');
    }
}
