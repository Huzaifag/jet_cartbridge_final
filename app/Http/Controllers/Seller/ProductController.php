<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Auth::user()->seller->products();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->stock_range) {
            $stockRange = explode('-', $request->stock_range);
            $query->whereBetween('stock_quantity', [
                (int)($stockRange[0] ?? 0),
                (int)($stockRange[1] ?? PHP_INT_MAX)
            ]);
        }

        if ($request->price_range) {
            $priceRange = explode('-', $request->price_range);
            $query->whereBetween('price', [
                (int)($priceRange[0] ?? 0),
                (int)($priceRange[1] ?? PHP_INT_MAX)
            ]);
        }

        $products = $query->latest()->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
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
                $image->move(public_path('product-images'), $newName);
                $imagePaths[] = 'product-images/' . $newName;
            }
        }

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
            'specifications' => $validated['specifications'] ?? [],
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

    public function show(string $id)
    {
        $product = Auth::user()->seller->products()->findOrFail($id);
        return view('seller.products.show', compact('product'));
    }

    public function edit(string $id)
    {
        $product = Auth::user()->seller->products()->findOrFail($id);
        return view('seller.products.edit', compact('product'));
    }

    public function update(Request $request, string $id)
    {
        $product = Auth::user()->seller->products()->findOrFail($id);

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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive,out_of_stock',
        ]);

        $imagePaths = $product->images ?? [];

        if ($request->hasFile('images')) {
            // Delete old images
            foreach ($imagePaths as $oldImage) {
                if (File::exists(public_path($oldImage))) {
                    File::delete(public_path($oldImage));
                }
            }

            // Upload new images
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $newName = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('product-images'), $newName);
                $imagePaths[] = 'product-images/' . $newName;
            }
        }

        $product->update([
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
            'specifications' => $validated['specifications'] ?? [],
            'images' => $imagePaths,
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'redirect' => route('seller.products.index')
        ]);
    }

    public function destroy(string $id)
    {
        $product = Auth::user()->seller->products()->findOrFail($id);

        // Delete product images
        if (!empty($product->images)) {
            foreach ($product->images as $image) {
                if (File::exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        if (!Auth::guard('seller')->check()) {
            return redirect()->route('seller.login')->with('error', 'You are not logged in as a seller');
        }

        $request->validate([
            'selected_ids' => 'required|string',
        ]);

        $ids = json_decode($request->selected_ids, true);

        if (empty($ids) || !is_array($ids)) {
            return redirect()->back()->with('error', 'No products selected for deletion.');
        }

        $products = auth('seller')->user()->products()->whereIn('id', $ids)->get();

        foreach ($products as $product) {
            if (!empty($product->images)) {
                foreach ($product->images as $image) {
                    if (File::exists(public_path($image))) {
                        File::delete(public_path($image));
                    }
                }
            }
            $product->delete();
        }

        return redirect()->route('seller.products.index')
            ->with('success', count($products) . ' product(s) deleted successfully.');
    }
}
