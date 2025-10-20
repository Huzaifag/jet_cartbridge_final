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
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class CartController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('customer')) {
            return redirect('/');
        }

        $cart = auth()->user()->cart;
        $subtotal = $cart ? $cart->total() : 0;
        $shipping = 10;

        $tax = 5;
        $total = $subtotal + $shipping + $tax;
        return view('frontend.cart.index', compact('cart', 'total', 'subtotal', 'shipping', 'tax'));
    }

    public function removeFromCart(CartItem $item)
    {
        if (!auth()->user()->hasRole('customer')) {
            return redirect('/');
        }

        $item->delete();
        return redirect()->back()->with('success', 'Item removed from cart');
    }

    public function addToCart(Product $product)
    {
        if (!auth()->user()->hasRole('customer')) {
            return redirect('/');
        }

        // Get or create user's active cart
        $cart = auth()->user()->cart()->firstOrCreate([
            'status' => 'active'
        ]);

        // Check if the product already exists in the cart
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        // Default quantity to add
        $quantityToAdd = 1;

        // Check for active promotion on this product
        $promotionRule = PromotionRule::where('applicable_product_id', $product->id)
            ->whereHas('promotion', function ($q) {
                $q->where('is_active', true)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now());
            })
            ->first();

        if ($promotionRule) {
            // Example: buy_quantity = 1, get_quantity = 1
            $buyQty = $promotionRule->buy_quantity;
            $getQty = $promotionRule->get_quantity;

            // For every "buy" product, calculate free products
            $freeQty = floor($quantityToAdd / $buyQty) * $getQty;
        } else {
            $freeQty = 0;
        }

        if ($cartItem) {
            // Product already in cart — increase quantity
            $cartItem->increment('quantity', $quantityToAdd);
        } else {
            // Create new cart item
            $cartItem = $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantityToAdd,
                'price' => $product->b2c_price,
            ]);
        }

        // Handle free product addition
        if ($freeQty > 0) {
            // Check if free product already exists in the cart
            $freeItem = $cart->items()->where('product_id', $product->id)
                ->where('is_free', true)
                ->first();

            if ($freeItem) {
                $freeItem->increment('quantity', $freeQty);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $freeQty,
                    'price' => 0,
                    'is_free' => true, // Add a boolean column in your cart_items table
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function selectAddress($cartId)
    {
        // Fetch the user's cart
        $cart = Cart::with(['items.product'])->findOrFail($cartId);

        // Fetch user’s saved addresses
        $addresses = auth()->user()->contacts ?? collect();

        // Calculate summary details for only selected items
        $selectedItems = $cart->items->where('is_selected', true);
        $itemCount = $selectedItems->count();
        $subtotal = $selectedItems->sum(fn($item) => $item->price * $item->quantity);
        $shipping = $subtotal > 50 ? 0 : 5; // Example: free shipping for orders over $50
        $tax = round($subtotal * 0.1, 2);
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
        $request->validate([
            'address_id' => 'required|exists:user_contacts,id',
        ]);

        // Store selected address in session for order processing
        session(['selected_address_id' => $request->address_id]);

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
        $shipping = $subtotal > 50 ? 0 : 10; // Free shipping over $50
        $tax = round($subtotal * 0.08, 2); // 8% tax
        $total = $subtotal + $shipping + $tax;

        // Get selected address details
        $selectedAddress = auth()->user()->contacts()->find($request->address_id);

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
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:cod,card,upi',
        ]);

        // Get selected address from session
        $addressId = session('selected_address_id');
        if (!$addressId) {
            return redirect()
                ->route('order.select-address', $cart->id)
                ->with('error', 'Please select a delivery address first.');
        }

        // Fetch selected items
        $selectedItems = $cart->items()
            ->where('is_selected', true)
            ->with('product')
            ->get();

        if ($selectedItems->isEmpty()) {
            return redirect()
                ->route('cart')
                ->with('warning', 'No items selected for order.');
        }

        $createdOrders = [];

        DB::transaction(function () use ($cart, $selectedItems, $request, $addressId, &$createdOrders) {

            // Fetch and format selected address
            $selectedAddress = auth()->user()->contacts()->find($addressId);
            $addressString = $selectedAddress
                ? "{$selectedAddress->address}, {$selectedAddress->city}, {$selectedAddress->state} {$selectedAddress->postal_code}, {$selectedAddress->country}"
                : 'N/A';

            // Group items by seller
            $itemsBySeller = $selectedItems->groupBy(fn($item) => $item->product->seller_id);

            foreach ($itemsBySeller as $sellerId => $items) {

                // Calculate total
                $total = $items->sum(fn($item) => $item->price * $item->quantity);

                // Create order
                $order = Order::create([
                    'status' => 'Order Placed',
                    'seller_id' => $sellerId,
                    'customer_id' => auth()->id(),
                    'total' => $total,
                    'payment_status' => 'pending',
                    'payment_method' => $request->payment_method,
                    'shipping_address' => $addressString,
                    'billing_address' => $addressString,
                    'notes' => '',
                ]);

                // ✅ Insert order stages (fixing SQL mismatch)
                $stages = [
                    ['stage' => 'order_placed', 'status' => 'completed', 'started_at' => now(), 'completed_at' => now()],
                    ['stage' => 'with_accountant', 'status' => 'pending'],
                    ['stage' => 'invoice_stage', 'status' => 'pending'],
                    ['stage' => 'in_production', 'status' => 'pending'],
                    ['stage' => 'delivery', 'status' => 'pending'],
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

            // Remove selected cart items
            $cart->items()->where('is_selected', true)->delete();

            // Clear selected address
            session()->forget('selected_address_id');

            // Optionally delete empty cart
            if ($cart->items()->count() === 0) {
                $cart->delete();
            }
        });

        return redirect()
            ->route('cart')
            ->with('success', 'Order placed successfully!');
    }


    public function order(Cart $cart)
    {
        // dd($cart);
        // Fetch only selected cart items with their related products
        $selectedItems = $cart->items()
            ->where('is_selected', true)
            ->with('product') // eager load product to get seller_id
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
            $cart->items()
                ->where('is_selected', true)
                ->delete();

            // The remaining (unselected) items stay in the cart
        });

        return redirect()->back()->with('success', 'Order placed successfully!');
    }



    public function toggleItemSelection(Request $request, CartItem $cartItem)
    {
        // Verify the cart item belongs to the authenticated user
        if ($cartItem->cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $cartItem->is_selected = $request->input('is_selected', !$cartItem->is_selected);
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
        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $selectAll = $request->input('select_all', true);

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
        // Verify the cart belongs to the authenticated user
        if ($cart->user_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action'
            ], 403);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:cart_items,id',
            'items.*.is_selected' => 'required|boolean'
        ]);

        $items = $request->input('items');
        $updated = 0;

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
        $shipping = $selectedItems->count() > 0 ? 15 : 0; // Default shipping
        $tax = $subtotal * 0.08; // 8% tax
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

        $cartItem->quantity = $request->input('quantity');
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully',
            'quantity' => $cartItem->quantity,
            'item_total' => number_format($cartItem->price * $cartItem->quantity, 2)
        ]);
    }

}
