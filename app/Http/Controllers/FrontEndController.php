<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\Seller;
use App\Models\UserInquiry;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FrontendController extends Controller
{

    public function index(Request $request)
    {
        // Base query
        $query = Product::query()
            ->select('products.*')
            ->where('products.status', 'active')
            ->with('seller', 'category');

        /* ==============================
         * 🔍 SEARCH FILTER
         * ============================== */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                    ->orWhere('products.description', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('categories.name', 'like', "%{$search}%");
                    });
            });
        }

        /* ==============================
         * 💰 PRICE FILTER
         * ============================== */
        if ($request->filled('price')) {
            switch ($request->price) {
                case 'low_to_high':
                    $query->orderBy('products.b2c_price', 'asc');
                    break;
                case 'high_to_low':
                    $query->orderBy('products.b2c_price', 'desc');
                    break;
                case 'under_100':
                    $query->where('products.b2c_price', '<', 100);
                    break;
                case '100_500':
                    $query->whereBetween('products.b2c_price', [100, 500]);
                    break;
                case 'over_500':
                    $query->where('products.b2c_price', '>', 500);
                    break;
            }
        }

        /* ==============================
         * ⭐ RATING FILTER
         * ============================== */
        if ($request->filled('rating')) {
            $rating = $request->rating;
            $query->whereHas('reviews', function ($q) use ($rating) {
                $q->selectRaw('product_id, AVG(rating) as avg_rating')
                    ->groupBy('product_id')
                    ->havingRaw('AVG(rating) >= ?', [$rating]);
            });
        }

        /* ==============================
         * 🏪 SELLER TYPE FILTER
         * ============================== */
        if ($request->filled('seller_type')) {
            $sellerTypes = $request->seller_type;

            $query->whereHas('seller', function ($q) use ($sellerTypes) {
                if (in_array('verified_manuf', $sellerTypes)) {
                    $q->where('sellers.is_verified', true);
                }
            });

            if (in_array('bulk_orders', $sellerTypes)) {
                $query->where('products.b2b_moq', '>', 0);
            }
        }

        /* ==============================
         * 📍 LOCATION FILTER (GPS NEAREST)
         * ============================== */
        if ($request->filled('location') && in_array('nearest', $request->location)) {
            $userLat = $request->input('user_lat');
            $userLng = $request->input('user_lng');
            $radius = $request->input('radius', 10);

            if ($userLat && $userLng) {
                $query->join('sellers', 'products.seller_id', '=', 'sellers.id')
                    ->whereNotNull('sellers.latitude')
                    ->whereNotNull('sellers.longitude')
                    ->selectRaw("
                    products.*, 
                    (6371 * acos(
                        cos(radians(?)) * cos(radians(sellers.latitude)) *
                        cos(radians(sellers.longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(sellers.latitude))
                    )) AS distance
                ", [$userLat, $userLng, $userLat])
                    ->having('distance', '<=', $radius)
                    ->orderBy('distance', 'asc');
            }
        }

        /* ==============================
         * 📦 CATEGORY FILTER
         * ============================== */
        if ($request->filled('category')) {
            $query->where('products.category_id', $request->category);
        }

        /* ==============================
         * 🧭 SORTING PRIORITIES
         * ============================== */
        $query->leftJoin('sellers', 'products.seller_id', '=', 'sellers.id');

        $query->orderByRaw('(SELECT COUNT(*) FROM reviews WHERE reviews.product_id = products.id) DESC')
            ->orderBy('products.rating', 'desc')
            ->orderByRaw('CASE WHEN products.is_featured = 1 THEN 1 ELSE 0 END DESC')
            ->orderByRaw('CASE WHEN sellers.is_premium = 1 THEN 1 ELSE 0 END DESC');

        /* ==============================
         * 🔠 RELEVANCE SORT (SEARCH)
         * ============================== */
        if ($request->filled('search')) {
            $search = $request->search;
            $query->leftJoin('categories', 'products.category_id', '=', 'categories.id')
                ->orderByRaw("CASE
                WHEN products.name LIKE ? THEN 1
                WHEN products.description LIKE ? THEN 2
                WHEN categories.name LIKE ? THEN 3
                ELSE 4
            END ASC", ["%{$search}%", "%{$search}%", "%{$search}%"]);
        }

        /* ==============================
         * 📍 FALLBACK LOGIC (IF EMPTY)
         * ============================== */
        $featuredProducts = $query->paginate(12);

        if ($request->filled('location') && in_array('nearest', $request->location) && $featuredProducts->isEmpty()) {
            foreach ([25, 50, 100] as $newRadius) {
                $query = Product::query()
                    ->select('products.*')
                    ->where('products.status', 'active')
                    ->with('seller');

                $userLat = $request->input('user_lat');
                $userLng = $request->input('user_lng');
                if ($userLat && $userLng) {
                    $query->join('sellers', 'products.seller_id', '=', 'sellers.id')
                        ->selectRaw("
                        products.*, 
                        (6371 * acos(
                            cos(radians(?)) * cos(radians(sellers.latitude)) *
                            cos(radians(sellers.longitude) - radians(?)) +
                            sin(radians(?)) * sin(radians(sellers.latitude))
                        )) AS distance
                    ", [$userLat, $userLng, $userLat])
                        ->having('distance', '<=', $newRadius)
                        ->orderBy('distance', 'asc');
                }

                $featuredProducts = $query->paginate(12);
                if (!$featuredProducts->isEmpty())
                    break;
            }
        }

        /* ==============================
         * 🏭 FETCH RELATED DATA
         * ============================== */
        $sellers = Seller::with('products')
            ->where('sellers.status', 'approved')
            ->latest()
            ->paginate(6);

        $manufacturers = Manufacturer::with('products')
            ->latest()
            ->paginate(6);

        $categories = Category::withCount('products')->get();

        /* ==============================
         * 👥 FOLLOWED SELLERS/MANUFACTURERS PRODUCTS
         * ============================== */
        $followedProducts = collect();
        $trendingProducts = collect();
        $premiumSellers = collect();

        if (auth()->check()) {
            // Get products from followed sellers
            $followedSellerIds = auth()->user()->followedSellers()->pluck('seller_id');
            $followedManufacturerIds = auth()->user()->followedManufacturers()->pluck('manufacturer_id');

            $followedProducts = Product::where('status', 'active')
                ->where(function ($q) use ($followedSellerIds, $followedManufacturerIds) {
                    $q->whereIn('seller_id', $followedSellerIds)
                        ->orWhereIn('manufacturer_id', $followedManufacturerIds);
                })
                ->with(['seller', 'manufacturer'])
                ->latest()
                ->take(8)
                ->get();
        }

        // Get trending products (most reviewed/rated)
        $trendingProducts = Product::where('status', 'active')
            ->withCount('reviews')
            ->orderBy('reviews_count', 'desc')
            ->orderBy('rating', 'desc')
            ->take(8)
            ->get();

        // Get premium sellers
        $premiumSellers = Seller::where('status', 'approved')
            ->where('is_premium', true)
            ->with('products')
            ->take(6)
            ->get();

        /* ==============================
         * 🖥️ RETURN VIEW
         * ============================== */
        return view('frontend.pages.index', compact(
            'featuredProducts',
            'sellers',
            'manufacturers',
            'categories',
            'followedProducts',
            'trendingProducts',
            'premiumSellers'
        ));
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

            // Check if logged-in user is the seller of this product
            if (auth()->check() && auth()->user()->seller && auth()->user()->seller->id === $product->seller_id) {
                return redirect()->route('product.show', $slug)->with('error', 'You cannot send an inquiry for your own product.');
            }

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
            'contact_id' => 'required|exists:user_contacts,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'target_price' => 'nullable|numeric|min:0',
            'destination' => 'nullable|string|max:255',
            'deadline' => 'nullable|date',
            'message' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        if (auth()->user()->seller && $product->seller_id === auth()->user()->seller->id) {
            return redirect()->back()->with('error', 'You cannot send an inquiry to your own product.');
        }
        $seller = $product->seller;
        $contact = \App\Models\UserContact::findOrFail($validated['contact_id']);

        $inquiry = UserInquiry::create(array_merge($validated, [
            'seller_id' => $seller->id,
            'customer_id' => auth()->id(),
        ]));

        // Automatically create a Lead for salesmen
        \App\Models\Lead::create([
            'inquiry_id' => $inquiry->id,
            'seller_id' => $seller->id,
            'buyer_id' => auth()->id(),
            'buyer_name' => $contact->name,
            'buyer_phone' => $contact->phone,
            'email' => $contact->email ?? auth()->user()->email,
            'product_id' => $validated['product_id'],
            'message' => $validated['message'] ?? 'B2B Inquiry for ' . $product->name,
            'quantity' => $validated['quantity'],
            'target_price' => $validated['target_price'],
            'status' => 'pending',
            'priority' => 'medium',
        ]);

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

    public function profile()
    {
        $user = auth()->user();

        // Products Purchased - get from orders
        $purchasedProducts = $user->orders()
            ->with(['orderItems.product'])
            ->get()
            ->pluck('orderItems')
            ->flatten()
            ->pluck('product')
            ->unique('id');

        // Followed Sellers/Manufacturers
        $followedSellers = $user->followedSellers()->with('products')->get();
        $followedManufacturers = $user->followedManufacturers()->with('products')->get();

        // Liked/Uploaded Reviews & Videos
        $userReviews = $user->reviews()->with('product')->latest()->get();

        // Coins Balance
        $coinsBalance = $user->customerProfile ? $user->customerProfile->coins : 0;

        return view('frontend.pages.profile', compact(
            'purchasedProducts',
            'followedSellers',
            'followedManufacturers',
            'userReviews',
            'coinsBalance'
        ));
    }

    public function contributorDashboard()
    {
        $user = auth()->user();

        // Check if user is seller or manufacturer
        $isSellerOrManufacturer = $user->seller || $user->manufacturer;

        if ($isSellerOrManufacturer) {
            // For sellers/manufacturers: Product Uploads
            $productUploads = 0;
            if ($user->seller) {
                $productUploads = $user->seller->products()->count();
            } elseif ($user->manufacturer) {
                $productUploads = $user->manufacturer->products()->count();
            }

            // Number of Reviews (reviews received on their products)
            $reviewsReceived = \App\Models\Review::whereHas('product', function ($q) use ($user) {
                if ($user->seller) {
                    $q->where('seller_id', $user->seller->id);
                } elseif ($user->manufacturer) {
                    $q->where('manufacturer_id', $user->manufacturer->id);
                }
            })->count();

            // Video Views & Likes (from reviews on their products)
            $videoViews = \App\Models\Review::whereHas('product', function ($q) use ($user) {
                if ($user->seller) {
                    $q->where('seller_id', $user->seller->id);
                } elseif ($user->manufacturer) {
                    $q->where('manufacturer_id', $user->manufacturer->id);
                }
            })->sum('video_views');

            $videoLikes = \App\Models\Review::whereHas('product', function ($q) use ($user) {
                if ($user->seller) {
                    $q->where('seller_id', $user->seller->id);
                } elseif ($user->manufacturer) {
                    $q->where('manufacturer_id', $user->manufacturer->id);
                }
            })->sum('video_likes');

            // Coins Earned (if applicable)
            $coinsEarned = $user->customerProfile ? $user->customerProfile->coins : 0;

            // Referral Link Shares
            $referralShares = $user->customerProfile ? $user->customerProfile->referral_shares : 0;

            return view('frontend.pages.contributor-dashboard', compact(
                'isSellerOrManufacturer',
                'productUploads',
                'reviewsReceived',
                'videoViews',
                'videoLikes',
                'coinsEarned',
                'referralShares'
            ));
        } else {
            // For customers: Number of Reviews, Video Views & Likes, Coins Earned, Referral Link Shares
            $numberOfReviews = $user->reviews()->count();

            // Video Views & Likes (from user's reviews)
            $videoViews = $user->reviews()->sum('video_views');
            $videoLikes = $user->reviews()->sum('video_likes');

            // Coins Earned
            $coinsEarned = $user->customerProfile ? $user->customerProfile->coins : 0;

            // Referral Link Shares
            $referralShares = $user->customerProfile ? $user->customerProfile->referral_shares : 0;

            return view('frontend.pages.contributor-dashboard', compact(
                'isSellerOrManufacturer',
                'numberOfReviews',
                'videoViews',
                'videoLikes',
                'coinsEarned',
                'referralShares'
            ));
        }
    }

    public function about()
    {
        return view('frontend.pages.about');
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function terms()
    {
        return view('frontend.pages.terms');
    }

    public function privacy()
    {
        return view('frontend.pages.privacy');
    }

    public function faq()
    {
        return view('frontend.pages.faq');
    }

    public function categories()
    {
        $categories = Category::withCount('products')->paginate(12);
        return view('frontend.pages.categories', compact('categories'));
    }

    public function sellers()
    {
        $sellers = Seller::with('products')
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);
        return view('frontend.pages.sellers', compact('sellers'));
    }

    public function manufacturers()
    {
        $manufacturers = Manufacturer::with('products')
            ->latest()
            ->paginate(12);
        return view('frontend.pages.manufacturers', compact('manufacturers'));
    }

    public function resources()
    {
        // For now, return a basic resources/blog page
        // Later this can be expanded with actual blog posts
        return view('frontend.pages.resources');
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
    public function sellerProfile($slug)
    {
        try {
            $seller = Seller::where('slug', $slug)->where('status', 'approved')->firstOrFail();

            // Get seller's products
            $products = Product::where('seller_id', $seller->id)
                ->where('status', 'active')
                ->latest()
                ->paginate(12);

            // Get past orders for logged-in user with this seller
            $pastOrders = collect();
            if (auth()->check()) {
                $pastOrders = \App\Models\Order::where('customer_id', auth()->id())
                    ->where('seller_id', $seller->id)
                    ->with(['orderItems.product', 'statuses'])
                    ->latest()
                    ->get();
            }

            return view('frontend.pages.seller-profile', compact('seller', 'products', 'pastOrders'));
        } catch (\Exception $e) {
            Log::error('Error fetching seller profile: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Seller not found.');
        }
    }
}
