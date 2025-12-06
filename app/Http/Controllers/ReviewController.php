<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ReviewController extends Controller
{
    public function store(Request $request, $productSlug)
    {
        $product = Product::where('slug', $productSlug)->firstOrFail();

        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'review_type' => 'required|in:text,text_image,video',
            'media' => 'nullable|array|max:5',
            'media.*' => 'file|mimes:jpeg,png,jpg,gif,mp4,mov,avi|max:10240', // 10MB max
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if user already reviewed this product
        $existingReview = Review::where('product_id', $product->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.'
            ], 422);
        }

        $mediaUrls = [];
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('reviews', 'public');
                $mediaUrls[] = $path;
            }
        }

        // generating ref code

        // ✅ Generate professional referral code
        $referralCode = $this->generateReferralCode(auth()->id());

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'review_type' => $request->review_type,
            'media_urls' => $mediaUrls,
            'is_verified_purchase' => $this->hasVerifiedPurchase($product->id),
            'referral_code' => $referralCode
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $review->load('user')
        ]);
    }

    public function orderWithFer(Review $review){
        $checkoutUrl = URL::temporarySignedRoute(
            'checkout.page',
            now()->addMinutes(15), // expires in 15 mins
            [
                'product_id' => $review->product_id,
                'referral_code' => $review->referral_code,
            ]
        );
    
        return redirect($checkoutUrl);
    }

    public function show(Request $request){
        $product = Product::findOrFail($request->input('product_id'));
        $review = Review::with('user')
        ->where('referral_code', $request->input('referral_code'))
        ->first();
        // dd($review);
        $userContacts = auth()->user()->contacts->toArray();

        return view('frontend.order.checkout', compact('product', 'review', 'userContacts'));
    }

    private function hasVerifiedPurchase($productId)
    {
        // Check if user has purchased this product
        return Auth::user()->orders()
            ->whereHas('orderItems', function ($query) use ($productId) {
                $query->where('product_id', $productId);
            })
            ->where('payment_status', 'paid')
            ->exists();
    }

    /**
     * ✅ Generate a professional, unique referral code
     */
    private function generateReferralCode($userId = null)
    {
        do {
            $prefix = 'RVW'; // short for "Review"
            $uniquePart = strtoupper(Str::random(6)); // e.g. 8F3K2L
            $userPart = $userId ? 'U' . str_pad($userId, 3, '0', STR_PAD_LEFT) : 'U000';
            $code = "{$prefix}-{$userPart}-{$uniquePart}";
        } while (Review::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Show video reviews in reels format
     */
    public function videoReels($productSlug = null)
    {
        $query = Review::with(['user', 'product'])
            ->where('review_type', 'video')
            ->whereNotNull('media_urls')
            ->orderBy('created_at', 'desc');

        if ($productSlug) {
            $product = Product::where('slug', $productSlug)->firstOrFail();
            $query->where('product_id', $product->id);
        }

        $videoReviews = $query->get();

        return view('frontend.pages.video-reviews', compact('videoReviews'));
    }

    /**
     * Track video view
     */
    public function trackView(Request $request, $reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->increment('video_views');

        return response()->json(['success' => true, 'views' => $review->video_views]);
    }

    /**
     * Toggle like on video review
     */
    public function toggleLike(Request $request, $reviewId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to like'
            ], 401);
        }

        $review = Review::findOrFail($reviewId);
        $userId = Auth::id();

        $like = \App\Models\ReviewLike::where('review_id', $reviewId)
            ->where('user_id', $userId)
            ->first();

        if ($like) {
            // Unlike
            $like->delete();
            $review->decrement('video_likes');
            $liked = false;
        } else {
            // Like
            \App\Models\ReviewLike::create([
                'review_id' => $reviewId,
                'user_id' => $userId,
            ]);
            $review->increment('video_likes');
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes' => $review->fresh()->video_likes
        ]);
    }

    /**
     * Get comments for a review
     */
    public function getComments($reviewId)
    {
        $comments = \App\Models\ReviewComment::with('user')
            ->where('review_id', $reviewId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($comment) {
                return [
                    'id' => $comment->id,
                    'text' => $comment->comment,
                    'user' => [
                        'name' => $comment->user->name,
                        'avatar' => $comment->user->avatar ? asset('storage/' . $comment->user->avatar) : null,
                    ],
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            });

        return response()->json([
            'comments' => $comments
        ]);
    }

    /**
     * Post a comment on a review
     */
    public function postComment(Request $request, $reviewId)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Please login to comment'
            ], 401);
        }

        $request->validate([
            'text' => 'required|string|max:500'
        ]);

        $comment = \App\Models\ReviewComment::create([
            'review_id' => $reviewId,
            'user_id' => Auth::id(),
            'comment' => $request->text,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Comment posted successfully',
            'comment' => [
                'id' => $comment->id,
                'text' => $comment->comment,
                'user' => [
                    'name' => Auth::user()->name,
                    'avatar' => Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : null,
                ],
                'created_at' => $comment->created_at->diffForHumans(),
            ]
        ]);
    }

    /**
     * Track share
     */
    public function trackShare(Request $request, $reviewId)
    {
        $request->validate([
            'platform' => 'required|in:whatsapp,facebook,twitter,copy'
        ]);

        \App\Models\ReviewShare::create([
            'review_id' => $reviewId,
            'user_id' => Auth::id(),
            'platform' => $request->platform,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Share tracked'
        ]);
    }
}
