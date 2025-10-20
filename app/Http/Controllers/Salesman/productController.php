<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class productController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->salesman->seller->products();

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
        return view('salesman.products.index', compact('products'));
    }

    public function create()
    {
        return view('salesman.products.create');
    }

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

        // Handle image uploads
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product-images', 'public');
                $imagePaths[] = $path;
            }
        }

        // Parse specifications from JSON string
        $specifications = [];
        if (!empty($validated['specifications'])) {
            $specifications = $validated['specifications'] ?? [];
        }

        // Create product
        $product = Auth::user()->salesman->seller->products()->create([
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
            'redirect' => route('salesman.products.index')
        ]);
    }

    public function bulkDelete(Request $request)
    {
        if (!Auth::guard('salesman')->check()) {
            return redirect()->route('login')->with('error', 'You are not logged in as a seller');
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
        $deleted = Auth::user()->salesman->seller->products()->whereIn('id', $ids)->delete();

        if ($deleted > 0) {
            return redirect()->route('seller.products.index')
                ->with('success', $deleted . ' product(s) have been deleted successfully.');
        }

        return redirect()->back()->with('error', 'No products were deleted.');
    }
}
