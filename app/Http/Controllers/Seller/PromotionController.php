<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\LuckyDraw;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\PromotionRule;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $sellerId = auth()->user()->seller->id;

        $promotions = Promotion::with([
            'rules.product',
            'luckyDraw',
            'seller'
        ])
            ->where('seller_id', $sellerId)
            ->latest()
            ->paginate(10);

        return view('seller.promotions.index', compact('promotions'));
    }

    public function create()
    {
        $sellerId = auth()->user()->seller->id;
        $products = Product::where('seller_id', $sellerId)->get();
        return view('seller.promotions.create', compact('products'));
    }

    public function store(Request $request)
    {
        // ✅ Common validation
        $baseRules = [
            'title'       => 'required|string|max:255',
            'type'        => 'required|in:buy_get,lucky_draw',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'is_active'   => 'nullable|boolean',
        ];

        // ✅ Type-specific rules
        if ($request->type === 'buy_get') {
            $extraRules = [
                'buy_quantity'          => 'required|integer|min:1',
                'get_quantity'          => 'required|integer|min:1',
                'applicable_product_id' => 'nullable|exists:products,id',
                'applicable_tag'        => 'nullable|string|max:255',
            ];
        } else { // lucky_draw
            $extraRules = [
                'minimum_purchase'  => 'required|numeric|min:0',
                'prize_description' => 'required|string|max:255',
                'draw_date'         => 'required|date|after_or_equal:start_date',
            ];
        }

        $validated = $request->validate(array_merge($baseRules, $extraRules));

        // ✅ Step 1: Create main promotion
        $promotion = Promotion::create([
            'seller_id'  => auth()->user()->seller->id,
            'title'      => $validated['title'],
            'type'       => $validated['type'],
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
            'is_active'  => $request->boolean('is_active', true),
        ]);

        // ✅ Step 2: Create related rule or lucky draw
        if ($validated['type'] === 'buy_get') {
            PromotionRule::create([
                'promotion_id'          => $promotion->id,
                'buy_quantity'          => $validated['buy_quantity'],
                'get_quantity'          => $validated['get_quantity'],
                'applicable_product_id' => $validated['applicable_product_id'] ?? null,
                'applicable_tag'        => $validated['applicable_tag'] ?? null,
            ]);
        } else {
            LuckyDraw::create([
                'promotion_id'      => $promotion->id,
                'minimum_purchase'  => $validated['minimum_purchase'],
                'prize_description' => $validated['prize_description'],
                'draw_date'         => $validated['draw_date'],
                'is_winner_announced' => false,
            ]);
        }

        // ✅ Step 3: Redirect
        return redirect()
            ->route('seller.promotions.index')
            ->with('success', 'Promotion created successfully!');
    }
}
