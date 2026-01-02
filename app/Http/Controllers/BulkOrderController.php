<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Category;
use App\Models\Product;
use App\Models\BulkOrder;
use App\Models\BulkOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BulkOrderController extends Controller
{
    /**
     * Show bulk order page with seller selection
     */
    public function index()
    {
        // Get all active sellers with their product counts
        $sellers = Seller::whereHas('products', function($query) {
            $query->where('status', 'active');
        })
        ->withCount(['products' => function($query) {
            $query->where('status', 'active');
        }])
        ->with(['user'])
        ->get();

        return view('frontend.bulk-order.index', compact('sellers'));
    }

    /**
     * Get seller categories via AJAX
     */
    public function getSellerCategories($sellerId)
    {
        $seller = Seller::findOrFail($sellerId);
        
        // Get categories that have products from this seller
        $categories = Category::whereHas('products', function($query) use ($sellerId) {
            $query->where('seller_id', $sellerId)
                  ->where('status', 'active');
        })
        ->withCount(['products' => function($query) use ($sellerId) {
            $query->where('seller_id', $sellerId)
                  ->where('status', 'active');
        }])
        ->get();

        return response()->json([
            'success' => true,
            'seller' => [
                'id' => $seller->id,
                'name' => $seller->user->name ?? $seller->company_name,
                'company_name' => $seller->company_name,
                'avatar' => $seller->user->avatar ?? null,
            ],
            'categories' => $categories->map(function($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'products_count' => $category->products_count,
                    'image' => $category->image ?? 'placeholder-category.jpg'
                ];
            })
        ]);
    }

    /**
     * Get products by seller and category
     */
    public function getCategoryProducts($sellerId, $categoryId)
    {
        $seller = Seller::findOrFail($sellerId);
        $category = Category::findOrFail($categoryId);
        
        $products = Product::where('seller_id', $sellerId)
            ->where('category_id', $categoryId)
            ->where('status', 'active')
            ->with(['category'])
            ->get();

        return response()->json([
            'success' => true,
            'seller' => [
                'id' => $seller->id,
                'name' => $seller->user->name ?? $seller->company_name,
                'company_name' => $seller->company_name,
            ],
            'category' => [
                'id' => $category->id,
                'name' => $category->name,
                'slug' => $category->slug,
            ],
            'products' => $products->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'b2b_price' => $product->b2b_price,
                    'b2b_moq' => $product->b2b_moq ?? 1,
                    'stock_quantity' => $product->stock_quantity,
                    'images' => $product->images ?? [],
                    'main_image' => $product->main_image ?? 'placeholder-product.jpg',
                    'rating' => $product->rating ?? 0,
                    'specifications' => $product->specifications ?? [],
                ];
            })
        ]);
    }

    /**
     * Store bulk order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|exists:sellers,id',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.price' => 'required|numeric|min:0',
            'delivery_address' => 'required|string|max:500',
            'delivery_date' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Calculate total amount
            $totalAmount = 0;
            foreach ($request->products as $productData) {
                $totalAmount += $productData['quantity'] * $productData['price'];
            }

            // Create bulk order
            $bulkOrder = BulkOrder::create([
                'user_id' => Auth::id(),
                'seller_id' => $request->seller_id,
                'order_number' => 'BO-' . date('Y') . '-' . str_pad(BulkOrder::count() + 1, 6, '0', STR_PAD_LEFT),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'delivery_address' => $request->delivery_address,
                'delivery_date' => $request->delivery_date,
                'notes' => $request->notes,
            ]);

            // Create bulk order items
            foreach ($request->products as $productData) {
                BulkOrderItem::create([
                    'bulk_order_id' => $bulkOrder->id,
                    'product_id' => $productData['product_id'],
                    'quantity' => $productData['quantity'],
                    'unit_price' => $productData['price'],
                    'total_price' => $productData['quantity'] * $productData['price'],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Bulk order submitted successfully!',
                'order_number' => $bulkOrder->order_number,
                'bulk_order_id' => $bulkOrder->id,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create bulk order. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show bulk order details
     */
    public function show($id)
    {
        $bulkOrder = BulkOrder::with(['user', 'seller.user', 'items.product'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('frontend.bulk-order.show', compact('bulkOrder'));
    }

    /**
     * Get user's bulk orders
     */
    public function myOrders()
    {
        $bulkOrders = BulkOrder::with(['seller.user', 'items'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.bulk-order.my-orders', compact('bulkOrders'));
    }

    /**
     * Search sellers
     */
    public function searchSellers(Request $request)
    {
        $query = $request->get('q', '');
        
        $sellers = Seller::whereHas('products', function($query) {
            $query->where('status', 'active');
        })
        ->where(function($q) use ($query) {
            $q->where('company_name', 'LIKE', "%{$query}%")
              ->orWhereHas('user', function($userQuery) use ($query) {
                  $userQuery->where('name', 'LIKE', "%{$query}%");
              });
        })
        ->withCount(['products' => function($query) {
            $query->where('status', 'active');
        }])
        ->with(['user'])
        ->limit(10)
        ->get();

        return response()->json([
            'success' => true,
            'sellers' => $sellers->map(function($seller) {
                return [
                    'id' => $seller->id,
                    'name' => $seller->user->name ?? $seller->company_name,
                    'company_name' => $seller->company_name,
                    'avatar' => $seller->user->avatar ?? null,
                    'products_count' => $seller->products_count,
                ];
            })
        ]);
    }
}