<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Get the current user's owner model and type
     */
    private function getCurrentOwner()
    {
        $user = Auth::user();
        
        if ($user->seller) {
            return [
                'model' => $user->seller,
                'type' => 'App\\Models\\Seller',
                'role' => 'seller'
            ];
        }
        
        if ($user->manufacturer) {
            return [
                'model' => $user->manufacturer,
                'type' => 'App\\Models\\Manufacturer',
                'role' => 'manufacturer'
            ];
        }
        
        if ($user->salesman) {
            return [
                'model' => $user->salesman,
                'type' => 'App\\Models\\Salesman',
                'role' => 'salesman'
            ];
        }
        
        return null;
    }

    public function index(Request $request)
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to manage products.');
        }

        $query = Product::accessibleBy($owner);

        // Apply filters
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->latest()->paginate(10);
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'categories', 'owner'));
    } 
   public function create()
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to create products.');
        }

        $categories = Category::all();
        return view('admin.products.create', compact('categories', 'owner'));
    }

    public function store(Request $request)
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to create products.'
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'b2c_price' => 'required|numeric|min:0',
            'b2c_compare_price' => 'nullable|numeric|min:0',
            'b2b_price' => 'required|numeric|min:0',
            'b2b_moq' => 'required|integer|min:1',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
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

        $productData = [
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . uniqid(),
            'description' => $validated['description'],
            'b2c_price' => $validated['b2c_price'],
            'b2c_compare_price' => $validated['b2c_compare_price'] ?? null,
            'b2b_price' => $validated['b2b_price'],
            'b2b_moq' => $validated['b2b_moq'],
            'stock_quantity' => $validated['stock_quantity'],
            'category_id' => $validated['category_id'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'specifications' => $validated['specifications'] ?? [],
            'images' => $imagePaths,
            'status' => $validated['status'],
            'verification_status' => 'pending',
            'owner_type' => $owner['type'],
            'owner_id' => $owner['model']->id,
        ];

        // Set legacy fields for backward compatibility
        if ($owner['role'] === 'seller') {
            $productData['seller_id'] = $owner['model']->id;
        } elseif ($owner['role'] === 'manufacturer') {
            $productData['manufacturer_id'] = $owner['model']->id;
        }

        $product = Product::create($productData);

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'redirect' => route('admin.products.index')
        ]);
    }

    public function show(string $id)
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to view products.');
        }

        $product = Product::accessibleBy($owner)->findOrFail($id);
        return view('admin.products.show', compact('product', 'owner'));
    }

    public function edit(string $id)
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to edit products.');
        }

        $product = Product::accessibleBy($owner)->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories', 'owner'));
    }

    public function update(Request $request, string $id)
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to update products.'
            ], 403);
        }

        $product = Product::accessibleBy($owner)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'b2c_price' => 'required|numeric|min:0',
            'b2c_compare_price' => 'nullable|numeric|min:0',
            'b2b_price' => 'required|numeric|min:0',
            'b2b_moq' => 'required|integer|min:1',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'specifications' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive,out_of_stock',
        ]);

        $imagePaths = $product->images ?? [];

        // Handle existing images
        if ($request->has('existing_images')) {
            $imagePaths = $request->existing_images;
        } else {
            $imagePaths = [];
        }

        if ($request->hasFile('images')) {
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
            'category_id' => $validated['category_id'],
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'specifications' => $validated['specifications'] ?? [],
            'images' => $imagePaths,
            'status' => $validated['status'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'redirect' => route('admin.products.index')
        ]);
    }

    public function destroy(string $id)
    {
        $owner = $this->getCurrentOwner();
        
        if (!$owner) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to delete products.');
        }

        $product = Product::byOwner($owner['type'], $owner['model']->id)->findOrFail($id);

        // Delete product images
        if (!empty($product->images)) {
            foreach ($product->images as $image) {
                if (File::exists(public_path($image))) {
                    File::delete(public_path($image));
                }
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}