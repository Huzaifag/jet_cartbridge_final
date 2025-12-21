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
        // Increase PHP limits programmatically
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '110M');
        ini_set('max_execution_time', '300');
        ini_set('memory_limit', '256M');
        
        $product = Product::where('slug', $productSlug)->firstOrFail();

        // Check for upload errors first
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $uploadError = $file->getError();
                if ($uploadError !== UPLOAD_ERR_OK) {
                    $errorMessages = [
                        UPLOAD_ERR_INI_SIZE => 'File is too large (exceeds upload_max_filesize)',
                        UPLOAD_ERR_FORM_SIZE => 'File is too large (exceeds MAX_FILE_SIZE)',
                        UPLOAD_ERR_PARTIAL => 'File was only partially uploaded',
                        UPLOAD_ERR_NO_FILE => 'No file was uploaded',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing temporary folder',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                        UPLOAD_ERR_EXTENSION => 'File upload stopped by extension',
                    ];
                    
                    $errorMessage = $errorMessages[$uploadError] ?? 'Unknown upload error';
                    
                    \Log::error('File upload error', [
                        'file' => $file->getClientOriginalName(),
                        'error_code' => $uploadError,
                        'error_message' => $errorMessage,
                        'file_size' => $file->getSize(),
                        'php_upload_max' => ini_get('upload_max_filesize'),
                        'php_post_max' => ini_get('post_max_size')
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'errors' => ["media.{$index}" => [$errorMessage . " (Error code: {$uploadError})"]]
                    ], 422);
                }
                
                \Log::info('File upload details', [
                    'file' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'is_valid' => $file->isValid()
                ]);
            }
        }

        // Simplified validation - remove file validation temporarily
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'review_type' => 'required|in:text,text_image,video',
            'media' => 'nullable|array|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Manual file validation with better error reporting
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                if (!$file->isValid()) {
                    \Log::error('Invalid file detected', [
                        'file' => $file->getClientOriginalName(),
                        'error' => $file->getError(),
                        'error_message' => $file->getErrorMessage()
                    ]);
                    
                    return response()->json([
                        'success' => false,
                        'errors' => ["media.{$index}" => ['Invalid file: ' . $file->getErrorMessage()]]
                    ], 422);
                }
                
                // Check file size manually
                $fileSize = $file->getSize();
                $maxSize = 100 * 1024 * 1024; // 100MB
                
                if ($fileSize > $maxSize) {
                    return response()->json([
                        'success' => false,
                        'errors' => ["media.{$index}" => ['File size (' . round($fileSize/1024/1024, 2) . 'MB) exceeds maximum allowed size (100MB)']]
                    ], 422);
                }
                
                // Check file type
                $extension = strtolower($file->getClientOriginalExtension());
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi'];
                
                if (!in_array($extension, $allowedExtensions)) {
                    return response()->json([
                        'success' => false,
                        'errors' => ["media.{$index}" => ['File type not allowed. Allowed types: ' . implode(', ', $allowedExtensions)]]
                    ], 422);
                }
            }
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
            foreach ($request->file('media') as $index => $file) {
                if (!$file->isValid()) {
                    return response()->json([
                        'success' => false,
                        'errors' => ["media.{$index}" => ['The file failed to upload. Please check file size and format.']]
                    ], 422);
                }

                try {
                    $path = $file->store('reviews', 'public');
                    if ($path) {
                        $mediaUrls[] = $path;
                    } else {
                        return response()->json([
                            'success' => false,
                            'errors' => ["media.{$index}" => ['Failed to store the uploaded file.']]
                        ], 422);
                    }
                } catch (\Exception $e) {
                    return response()->json([
                        'success' => false,
                        'errors' => ["media.{$index}" => ['File upload failed: ' . $e->getMessage()]]
                    ], 422);
                }
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
     * Test file upload functionality
     */
    public function testUpload(Request $request)
    {
        $debug = [
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'has_files' => $request->hasFile('media'),
            'files_count' => $request->hasFile('media') ? count($request->file('media')) : 0,
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
        ];
        
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $debug["file_{$index}"] = [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'error' => $file->getError(),
                    'is_valid' => $file->isValid(),
                ];
            }
        }
        
        return response()->json($debug);
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
