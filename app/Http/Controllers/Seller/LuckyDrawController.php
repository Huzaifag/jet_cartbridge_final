<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\LuckyDraw;
use Illuminate\Http\Request;

class LuckyDrawController extends Controller
{
    /**
     * Display the entries for a specific lucky draw.
     */
    public function entries(LuckyDraw $luckyDraw)
    {
        // Ensure the seller can only view their own lucky draws
        // $this->authorize('view', $luckyDraw->promotion);

        $luckyDraw->load('promotion.entries.customer');
        return view('seller.promotions.lucky-draws.entries', compact('luckyDraw'));
    }
}