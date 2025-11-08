<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\PromotionRule;
use App\Models\UserContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;
use Auth;

class CartController extends Controller
{
    public function index()
    {
        // Authorization check - ensure only customers can access cart
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            abort(403, 'Unauthorized access to cart');
        }

        $cart = auth()->user()->cart;
        $subtotal = $cart ? $cart->total() : 0;
        $shipping = $subtotal > 50 ? 0 : 10;  // Free shipping over $50
        $tax = round($subtotal * 0.08, 2);  // 8% tax
        $total = $subtotal + $shipping + $tax;

        return view('frontend.cart.index', compact('cart', 'total', 'subtotal', 'shipping', 'tax'));
    }

    public function removeFromCart(CartItem $item)
    {
        // Authorization check - ensure user owns this cart item
        if ($item->cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to cart item');
        }

        $item->delete();
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function addToCart(Request $request, Product $product)
    {
        // Rate limiting to prevent spam
        $key = 'add-to-cart:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 10)) {  // 10 attempts per minute
            return redirect()->back()->with('error', 'Too many requests. Please try again later.');
        }
        RateLimiter::hit($key, 60);  // 60 second window

        // Authorization check
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            abort(403, 'Unauthorized access');
        }

        // Validate product availability
        if ($product->status !== 'active') {
            return redirect()->back()->with('error', 'Product is not available for purchase.');
        }

        // Validate request
        $request->validate([
            'quantity' => 'nullable|integer|min:1|max:99'
        ]);

        $quantityToAdd = $request->input('quantity', 1);

        // Check stock availability (assuming product has stock field)
        if (isset($product->stock) && $product->stock < $quantityToAdd) {
            return redirect()->back()->with('error', 'Insufficient stock available.');
        }

        // Get or create user's active cart
        $cart = auth()->user()->cart()->firstOrCreate([
            'status' => 'active'
        ]);

        // Check if the product already exists in the cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        // Check for active promotion on this product
        $promotionRule = PromotionRule::where('applicable_product_id', $product->id)
            ->whereHas('promotion', function ($q) {
                $q
                    ->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            })
            ->first();

        $freeQty = 0;
        if ($promotionRule) {
            // Example: buy_quantity = 1, get_quantity = 1
            $buyQty = $promotionRule->buy_quantity;
            $getQty = $promotionRule->get_quantity;

            // For every "buy" product, calculate free products
            $freeQty = floor($quantityToAdd / $buyQty) * $getQty;
        }

        DB::transaction(function () use ($cart, $cartItem, $product, $quantityToAdd, $freeQty) {
            if ($cartItem) {
                // Product already in cart — increase quantity
                $cartItem->increment('quantity', $quantityToAdd);
            } else {
                // Create new cart item
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantityToAdd,
                    'price' => $product->b2c_price,
                    'is_selected' => true,  // Auto-select new items
                ]);
            }

            // Handle free product addition
            if ($freeQty > 0) {
                // Check if free product already exists in the cart
                $freeItem = $cart
                    ->items()
                    ->where('product_id', $product->id)
                    ->where('is_free', true)
                    ->first();

                if ($freeItem) {
                    $freeItem->increment('quantity', $freeQty);
                } else {
                    $cart->items()->create([
                        'product_id' => $product->id,
                        'quantity' => $freeQty,
                        'price' => 0,
                        'is_free' => true,
                        'is_selected' => true,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function selectAddress($cartId)
    {
        // Authorization check
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            abort(403, 'Unauthorized access');
        }

        // Fetch the user's cart with authorization
        $cart = Cart::where('id', $cartId)
            ->where('user_id', auth()->id())
            ->with(['items.product'])
            ->firstOrFail();

        // Check if cart has selected items
        $selectedItems = $cart->items->where('is_selected', true);
        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart')->with('warning', 'Please select items to checkout.');
        }

        // Fetch user's saved addresses
        $addresses = auth()->user()->contacts ?? collect();

        // Calculate summary details for only selected items
        $itemCount = $selectedItems->count();
        $subtotal = $selectedItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 50 ? 0 : 5;  // Free shipping for orders over $50
        $tax = round($subtotal * 0.08, 2);  // 8% tax
        $total = $subtotal + $shipping + $tax;

        // Return view with all necessary data
        return view('frontend.pages.select-address', compact(
            'cart',
            'addresses',
            'itemCount',
            'subtotal',
            'shipping',
            'tax',
            'total'
        ));
    }

    public function payment(Request $request)
    {
        // dd($request->address_id);
        // Authorization check
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            abort(403, 'Unauthorized access');
        }

        // Validate request with proper authorization
        $request->validate([
            'address_id' => [
                'required',
            ],
        ]);

        // dd($request->address_id);

        // Verify address belongs to user
        $selectedAddress = auth()->user()->contacts()->find($request->address_id);
        if (!$selectedAddress) {
            return redirect()->back()->with('error', 'Invalid address selection.');
        }

        // Store selected address in session with expiration
        session(['selected_address_id' => $request->address_id]);
        session(['address_selected_at' => now()]);

        // Get user's cart and selected items
        $cart = auth()->user()->cart;
        if (!$cart) {
            return redirect()->route('cart')->with('error', 'No active cart found.');
        }

        $selectedItems = $cart->items()->where('is_selected', true)->with('product')->get();
        if ($selectedItems->isEmpty()) {
            return redirect()->route('cart')->with('warning', 'No items selected for checkout.');
        }

        // Calculate order summary
        $subtotal = $selectedItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 50 ? 0 : 10;  // Free shipping over $50
        $tax = round($subtotal * 0.08, 2);  // 8% tax
        $total = $subtotal + $shipping + $tax;

        // Return payment view with data
        return view('frontend.pages.payment', compact(
            'cart',
            'selectedItems',
            'selectedAddress',
            'subtotal',
            'shipping',
            'tax',
            'total'
        ));
    }

    public function placeOrder(Request $request, Cart $cart)
    {
        // Authorization check
        if (!auth()->check() || !auth()->user()->hasRole('customer')) {
            abort(403, 'Unauthorized access');
        }

        // Verify cart ownership
        if ($cart->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to cart');
        }

        // Validate request
        $request->validate([
            'payment_method' => 'required|in:cod,card,upi',
        ]);

        // Check session expiration (15 minutes)
        $addressSelectedAt = session('address_selected_at');
        if (!$addressSelectedAt || now()->diffInMinutes($addressSelectedAt) > 15) {
            return redirect()
                ->route('order.select-address', $cart->id)
                ->with('error', 'Session expired. Please select address again.');
        }

        // Get selected address from session
        $addressId = session('selected_address_id');
        if (!$addressId) {
            return redirect()
                ->route('order.select-address', $cart->id)
                ->with('error', 'Please select a delivery address first.');
        }

        // Verify address still belongs to user
        $selectedAddress = auth()->user()->contacts()->find($addressId);
        if (!$selectedAddress) {
            return redirect()
                ->route('order.select-address', $cart->id)
                ->with('error', 'Invalid address selection.');
        }

        // Fetch selected items with lock for update
        $selectedItems = $cart
            ->items()
            ->where('is_selected', true)
            ->with('product')
            ->lockForUpdate()
            ->get();

        if ($selectedItems->isEmpty()) {
            return redirect()
                ->route('cart')
                ->with('warning', 'No items selected for order.');
        }

        // Check stock availability before placing order
        foreach ($selectedItems as $item) {
            if (isset($item->product->stock) && $item->product->stock < $item->quantity) {
                return redirect()->back()->with('error', "Insufficient stock for {$item->product->name}.");
            }
        }

        $createdOrders = [];

        DB::transaction(function () use ($cart, $selectedItems, $request, $selectedAddress, &$createdOrders) {
            // Format address string
            $addressString = "{$selectedAddress->address}, {$selectedAddress->city}, {$selectedAddress->state} {$selectedAddress->postal_code}, {$selectedAddress->country}";

            // Group items by seller OR manufacturer
            $itemsByVendor = $selectedItems->groupBy(function ($item) {
                // Check if product belongs to manufacturer or seller
                if ($item->product->manufacturer_id) {
                    return 'manufacturer_' . $item->product->manufacturer_id;
                } else {
                    return 'seller_' . $item->product->seller_id;
                }
            });

            foreach ($itemsByVendor as $vendorKey => $items) {
                // Calculate total
                $total = $items->sum(fn($item) => $item->price * $item->quantity);

                // Determine if this is a manufacturer or seller order
                [$vendorType, $vendorId] = explode('_', $vendorKey);

                // Create order with unique order number
                $orderNumber = 'ORD-' . strtoupper(uniqid());
                $orderData = [
                    'order_number' => $orderNumber,
                    'status' => 'Order Placed',
                    'customer_id' => auth()->id(),
                    'total' => $total,
                    'payment_status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'shipping_address' => $addressString,
                    'billing_address' => $addressString,
                    'notes' => '',
                ];

                // Set seller_id or manufacturer_id based on vendor type
                if ($vendorType === 'manufacturer') {
                    $orderData['manufacturer_id'] = $vendorId;
                    $orderData['seller_id'] = null;
                } else {
                    $orderData['seller_id'] = $vendorId;
                    $orderData['manufacturer_id'] = null;
                }

                $order = Order::create($orderData);

                // Insert order stages following the correct lifecycle
                // 1. Order Placed → 2. Salesman Review → 3. Accountant (Billing) → 4. Warehouse (Dispatch) → 5. Delivery
                $stages = [
                    ['stage' => 'order_placed', 'status' => 'completed', 'started_at' => now(), 'completed_at' => now()],
                    ['stage' => 'salesman_review', 'status' => 'in_progress', 'started_at' => now()],
                    ['stage' => 'accountant_billing', 'status' => 'pending'],
                    ['stage' => 'warehouse_dispatch', 'status' => 'pending'],
                    ['stage' => 'out_for_delivery', 'status' => 'pending'],
                    ['stage' => 'delivered', 'status' => 'pending'],
                ];

                foreach ($stages as $stage) {
                    OrderStatus::create([
                        'order_id' => $order->id,
                        'stage' => $stage['stage'],
                        'status' => $stage['status'],
                        'started_at' => $stage['started_at'] ?? null,
                        'completed_at' => $stage['completed_at'] ?? null,
                    ]);
                }

                // Create order items and update stock
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ]);

                    // Decrease product stock if available
                    if (isset($item->product->stock)) {
                        $item->product->decrement('stock', $item->quantity);
                    }
                }

                $createdOrders[] = $order;
            }

            // Remove selected cart items
            $cart->items()->where('is_selected', true)->delete();

            // Clear session
            session()->forget(['selected_address_id', 'address_selected_at']);

            // Delete empty cart
            if ($cart->items()->count() === 0) {
                $cart->delete();
            }
        });

        return redirect()
            ->route('cart')
            ->with('success', 'Order placed successfully! Order numbers: ' . collect($createdOrders)->pluck('order_number')->join(', '));
    }

    public function order(Cart $cart)
    {
        // dd($cart);
        // Fetch only selected cart items with their related products
        $selectedItems = $cart
            ->items()
            ->where('is_selected', true)
            ->with('product')  // eager load product to get seller_id
            ->get();

        // If no items selected, return warning
        if ($selectedItems->isEmpty()) {
            return redirect()->back()->with('warning', 'No items selected for order.');
        }

        $createdOrders = [];

        DB::transaction(function () use ($cart, $selectedItems, &$createdOrders) {
            // Group items by seller
            $itemsBySeller = $selectedItems->groupBy(fn($item) => $item->product->seller_id);

            foreach ($itemsBySeller as $sellerId => $items) {
                // Calculate total for this seller
                $total = $items->sum(fn($item) => $item->price * $item->quantity);

                // Create new order
                $order = Order::create([
                    'seller_id' => $sellerId,
                    'customer_id' => auth()->id(),
                    'total' => $total,
                    'payment_status' => 'pending',
                    'payment_method' => 'cod',
                    'shipping_address' => auth()->user()->address ?? 'N/A',
                    'billing_address' => auth()->user()->address ?? 'N/A',
                    'notes' => '',
                ]);

                // Insert initial order statuses
                $stages = [
                    ['stage' => 'order_placed', 'status' => 'completed', 'started_at' => now(), 'completed_at' => now()],
                    ['stage' => 'with_accountant', 'status' => 'in_progress'],
                    ['stage' => 'invoice_stage', 'status' => 'pending'],
                    ['stage' => 'in_production', 'status' => 'pending'],
                    ['stage' => 'delivery', 'status' => 'pending'],
                ];

                foreach ($stages as $stage) {
                    OrderStatus::create(array_merge([
                        'order_id' => $order->id,
                        'started_at' => null,
                        'completed_at' => null,
                    ], $stage));
                }

                // Create order items
                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                    ]);
                }

                $createdOrders[] = $order;
            }

            // ✅ Instead of deleting cart or all items:
            // Remove only the ordered (selected) items from the cart
            $cart
                ->items()
                ->where('is_selected', true)
                ->delete();

            // The remaining (unselected) items stay in the cart
        });

        return redirect()->back()->with('success', 'Order placed successfully!');
    }

    public function toggleItemSelection(Request $request, CartItem $cartItem)
    {
        // Rate limiting
        $key = 'cart-toggle:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 30)) {  // 30 attempts per minute
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Verify the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Validate request
        $request->validate([
            'is_selected' => 'required|boolean'
        ]);

        $cartItem->is_selected = $request->input('is_selected');
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Item selection updated',
            'is_selected' => $cartItem->is_selected
        ]);
    }

    /**
     * Select all cart items
     */
    public function selectAll(Cart $cart)
    {
        // Rate limiting
        $key = 'cart-select-all:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 20)) {  // 20 attempts per minute
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Update all cart items to selected
        $cart->items()->update(['is_selected' => true]);

        return response()->json([
            'success' => true,
            'message' => 'All items selected',
            'selected_count' => $cart->items()->count()
        ]);
    }

    /**
     * Deselect all cart items
     */
    public function deselectAll(Cart $cart)
    {
        // Rate limiting
        $key = 'cart-deselect-all:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 20)) {  // 20 attempts per minute
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Update all cart items to deselected
        $cart->items()->update(['is_selected' => false]);

        return response()->json([
            'success' => true,
            'message' => 'All items deselected',
            'selected_count' => 0
        ]);
    }

    /**
     * Toggle select all (if all selected, deselect all; otherwise select all)
     */
    public function toggleSelectAll(Request $request, Cart $cart)
    {
        // Rate limiting
        $key = 'cart-toggle-select-all:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 20)) {  // 20 attempts per minute
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        // Validate request
        $request->validate([
            'select_all' => 'required|boolean'
        ]);

        $selectAll = $request->input('select_all');

        // Update all cart items
        $cart->items()->update(['is_selected' => $selectAll]);

        $selectedCount = $selectAll ? $cart->items()->count() : 0;

        return response()->json([
            'success' => true,
            'message' => $selectAll ? 'All items selected' : 'All items deselected',
            'select_all' => $selectAll,
            'selected_count' => $selectedCount
        ]);
    }

    /**
     * Bulk update selection for multiple items
     */
    public function bulkUpdateSelection(Request $request, Cart $cart)
    {
        // Rate limiting
        $key = 'cart-bulk-update:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 15)) {  // 15 attempts per minute
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $request->validate([
            'items' => 'required|array|min:1|max:50',  // Limit to 50 items per request
            'items.*.id' => 'required|integer|exists:cart_items,id',
            'items.*.is_selected' => 'required|boolean'
        ]);

        $items = $request->input('items');
        $updated = 0;

        DB::transaction(function () use ($items, $cart, &$updated) {
            foreach ($items as $itemData) {
                $cartItem = CartItem::where('id', $itemData['id'])
                    ->where('cart_id', $cart->id)
                    ->first();

                if ($cartItem) {
                    $cartItem->is_selected = $itemData['is_selected'];
                    $cartItem->save();
                    $updated++;
                }
            }
        });

        $selectedCount = $cart->items()->where('is_selected', true)->count();

        return response()->json([
            'success' => true,
            'message' => "Updated {$updated} items",
            'updated_count' => $updated,
            'selected_count' => $selectedCount
        ]);
    }

    /**
     * Get selected items count and totals
     */
    public function getSelectedSummary(Cart $cart)
    {
        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $selectedItems = $cart->items()->where('is_selected', true)->get();

        $subtotal = $selectedItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $totalQuantity = $selectedItems->sum('quantity');
        $shipping = $selectedItems->count() > 0 ? 15 : 0;  // Default shipping
        $tax = $subtotal * 0.08;  // 8% tax
        $total = $subtotal + $shipping + $tax;

        return response()->json([
            'success' => true,
            'selected_count' => $selectedItems->count(),
            'total_quantity' => $totalQuantity,
            'subtotal' => number_format($subtotal, 2),
            'shipping' => number_format($shipping, 2),
            'tax' => number_format($tax, 2),
            'total' => number_format($total, 2)
        ]);
    }

    /**
     * Update quantity for a cart item
     */
    public function updateQuantity(Request $request, CartItem $cartItem)
    {
        // Rate limiting
        $key = 'cart-update-quantity:' . auth()->id();
        if (RateLimiter::tooManyAttempts($key, 30)) {  // 30 attempts per minute
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.'
            ], 429);
        }
        RateLimiter::hit($key, 60);

        // Verify the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $newQuantity = $request->input('quantity');

        // Check stock availability if product has stock
        if (isset($cartItem->product->stock) && $cartItem->product->stock < $newQuantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        $cartItem->quantity = $newQuantity;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully',
            'quantity' => $cartItem->quantity,
            'item_total' => number_format($cartItem->price * $cartItem->quantity, 2)
        ]);
    }
}
