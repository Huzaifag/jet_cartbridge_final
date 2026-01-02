<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ReviewController extends Controller
{


    public function store(Request $request, $productSlug)
    {
        // Find product
        $product = Product::where('slug', $productSlug)->firstOrFail();

        // Prevent duplicate reviews
        if (
            Review::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->exists()
        ) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this product.'
            ], 422);
        }

        /* ---------------- VALIDATION ---------------- */

        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'review_text' => 'nullable|string|max:1000',
            'review_type' => 'required|in:text,text_image,video',
            'media' => 'nullable|array|max:5',
            'media.*' => [
                'file',
                'max:102400', // 100MB
                function ($attribute, $file, $fail) {
                    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'avi', 'webm', 'mkv'];
                    $ext = strtolower($file->getClientOriginalExtension());

                    if (!in_array($ext, $allowed)) {
                        $fail('Unsupported file type.');
                    }
                }
            ],
        ];

        if ($request->review_type === 'video') {
            $rules['media'] = 'required|array|min:1';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        /* ---------------- STORE FILES LOCALLY ---------------- */

        $mediaUrls = [];
        $uploadedVideoCount = 0;

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {

                if (!$file->isValid()) {
                    continue;
                }

                $ext = strtolower($file->getClientOriginalExtension());
                $isVideo = in_array($ext, ['mp4', 'mov', 'avi', 'webm', 'mkv']);

                // Folder structure
                $folder = $isVideo
                    ? "reviews/{$product->id}/videos"
                    : "reviews/{$product->id}/images";

                // Store file
                // $path = $file->store($folder, 'public');

                $basePath = public_path('storage/reviews/' . $product->id);

                $subFolder = $isVideo ? 'videos' : 'images';

                $destination = $basePath . '/' . $subFolder;

                if (!file_exists($destination)) {
                    mkdir($destination, 0755, true);
                }

                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

                $file->move($destination, $fileName);

                $mediaUrls[] = asset("storage/reviews/{$product->id}/{$subFolder}/{$fileName}");

                if ($isVideo) {
                    $uploadedVideoCount++;
                }


                // if ($isVideo) {
                //     $uploadedVideoCount++;
                // }

                // // Public URL
                // $mediaUrls[] = asset('storage/' . $path);
            }
        }

        /* ---------------- FINAL VIDEO CHECK ---------------- */

        if ($request->review_type === 'video' && $uploadedVideoCount === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Video review must include at least one uploaded video.'
            ], 422);
        }

        /* ---------------- SAVE REVIEW ---------------- */

        $review = Review::create([
            'product_id' => $product->id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'review_text' => $request->review_text,
            'review_type' => $request->review_type,
            'media_urls' => $mediaUrls,
            'is_verified_purchase' => $this->hasVerifiedPurchase($product->id),
            'referral_code' => $this->generateReferralCode(Auth::id()),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $review->load('user')
        ], 200);
    }


    public function orderWithFer(Review $review)
    {
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

    public function show(Request $request)
    {
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
        $query = Review::with(['user', 'product', 'product.category'])
            ->where('review_type', 'video')
            ->whereNotNull('media_urls')
            ->where('media_urls', '!=', '[]')
            ->where('media_urls', '!=', 'null')
            ->orderBy('created_at', 'desc');

        if ($productSlug) {
            $product = Product::where('slug', $productSlug)->firstOrFail();
            
            // Get reviews for this specific product first
            $productReviews = $query->clone()->where('product_id', $product->id)->get();
            
            // Get reviews from same category (excluding current product)
            $categoryReviews = $query->clone()
                ->whereHas('product', function($q) use ($product) {
                    $q->where('category_id', $product->category_id)
                      ->where('id', '!=', $product->id);
                })
                ->limit(20) // Limit to prevent too many videos
                ->get();
            
            // Combine: product reviews first, then category reviews
            $videoReviews = $productReviews->concat($categoryReviews);
            
            return view('frontend.pages.video-reviews', compact('videoReviews', 'product'));
        }

        $videoReviews = $query->limit(50)->get();

        // Debug: Log video reviews data
        \Log::info('Video Reviews Debug:', [
            'total_reviews' => $videoReviews->count(),
            'sample_review' => $videoReviews->first() ? [
                'id' => $videoReviews->first()->id,
                'media_urls' => $videoReviews->first()->media_urls,
                'review_type' => $videoReviews->first()->review_type,
            ] : null
        ]);

        // Filter and validate video reviews
        $videoReviews = $videoReviews->filter(function($review) {
            // Ensure media_urls is properly formatted
            if (is_string($review->media_urls)) {
                $review->media_urls = json_decode($review->media_urls, true);
            }
            
            // Check if we have valid video URLs
            return is_array($review->media_urls) && 
                   count($review->media_urls) > 0 && 
                   !empty($review->media_urls[0]);
        });

        return view('frontend.pages.video-reviews', compact('videoReviews'));
    }

    /**
     * Get more video reviews for continuous viewing (AJAX endpoint)
     */
    public function getMoreVideoReviews(Request $request)
    {
        $categoryId = $request->input('category_id');
        $excludeIds = $request->input('exclude_ids', []);
        $limit = $request->input('limit', 10);

        $query = Review::with(['user', 'product', 'product.category'])
            ->where('review_type', 'video')
            ->whereNotNull('media_urls')
            ->whereNotIn('id', $excludeIds)
            ->orderBy('created_at', 'desc');

        if ($categoryId) {
            $query->whereHas('product', function($q) use ($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        $videoReviews = $query->limit($limit)->get();

        return response()->json([
            'success' => true,
            'reviews' => $videoReviews->map(function($review) {
                return [
                    'id' => $review->id,
                    'review_text' => $review->review_text,
                    'media_urls' => $review->media_urls,
                    'video_likes' => $review->video_likes ?? 0,
                    'video_views' => $review->video_views ?? 0,
                    'user' => [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                        'avatar' => $review->user->avatar ? asset('storage/' . $review->user->avatar) : null,
                        'slug' => Str::slug($review->user->name, '')
                    ],
                    'product' => [
                        'id' => $review->product->id,
                        'name' => $review->product->name,
                        'slug' => $review->product->slug,
                        'category_id' => $review->product->category_id
                    ]
                ];
            })
        ]);
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
            ->map(function ($comment) {
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
     * Debug upload functionality specifically for video reviews
     */
    public function debugUpload(Request $request)
    {
        $debug = [
            'request_data' => [
                'review_type' => $request->review_type,
                'rating' => $request->rating,
                'review_text' => $request->review_text,
                'has_files' => $request->hasFile('media'),
                'files_count' => $request->hasFile('media') ? count($request->file('media')) : 0,
            ],
            'php_config' => [
                'upload_max_filesize' => ini_get('upload_max_filesize'),
                'post_max_size' => ini_get('post_max_size'),
                'max_file_uploads' => ini_get('max_file_uploads'),
            ],
            'files' => [],
            'upload_results' => [],
        ];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'mkv']);

                $fileInfo = [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'size_mb' => round($file->getSize() / 1024 / 1024, 2),
                    'mime' => $file->getMimeType(),
                    'extension' => $extension,
                    'is_video' => $isVideo,
                    'error' => $file->getError(),
                    'is_valid' => $file->isValid(),
                ];

                $debug['files'][] = $fileInfo;

                // Test upload to Cloudinary
                if ($file->isValid()) {
                    try {
                        $options = [
                            'folder' => 'debug-uploads',
                            'public_id' => 'debug_' . uniqid(),
                            'resource_type' => $isVideo ? 'video' : 'image',
                        ];

                        if ($isVideo) {
                            $result = Cloudinary::uploadVideo($file->getRealPath(), $options);
                        } else {
                            $result = Cloudinary::upload($file->getRealPath(), $options);
                        }

                        $debug['upload_results'][] = [
                            'file_index' => $index,
                            'success' => true,
                            'url' => $result->getSecurePath(),
                            'public_id' => $result->getPublicId(),
                            'resource_type' => $result->getResourceType() ?? 'unknown',
                            'format' => $result->getFormat() ?? 'unknown',
                            'is_video_detected' => $isVideo,
                        ];
                    } catch (\Exception $e) {
                        $debug['upload_results'][] = [
                            'file_index' => $index,
                            'success' => false,
                            'error' => $e->getMessage(),
                            'is_video_detected' => $isVideo,
                        ];
                    }
                }
            }
        }

        // Test the video detection logic
        $uploadedVideoFiles = [];
        foreach ($debug['upload_results'] as $result) {
            if ($result['success'] && $result['is_video_detected']) {
                $uploadedVideoFiles[] = $result['url'];
            }
        }

        $debug['video_detection'] = [
            'uploaded_video_files' => $uploadedVideoFiles,
            'has_videos' => !empty($uploadedVideoFiles),
            'would_pass_validation' => $request->review_type !== 'video' || !empty($uploadedVideoFiles),
        ];

        return response()->json($debug, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Test file upload functionality
     */
    public function testUpload(Request $request)
    {
        $debug = [
            'php_version' => PHP_VERSION,
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size'),
            'max_file_uploads' => ini_get('max_file_uploads'),
            'max_execution_time' => ini_get('max_execution_time'),
            'memory_limit' => ini_get('memory_limit'),
            'has_files' => $request->hasFile('media'),
            'files_count' => $request->hasFile('media') ? count($request->file('media')) : 0,
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'content_length' => $request->header('Content-Length'),
            'cloudinary_configured' => !empty(config('cloudinary.cloud.cloud_name')),
        ];

        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $index => $file) {
                $debug["file_{$index}"] = [
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'size_mb' => round($file->getSize() / 1024 / 1024, 2),
                    'mime' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                    'error' => $file->getError(),
                    'error_message' => $file->getErrorMessage(),
                    'is_valid' => $file->isValid(),
                    'temp_path' => $file->getRealPath(),
                ];

                // Test Cloudinary upload
                if ($file->isValid()) {
                    try {
                        $extension = strtolower($file->getClientOriginalExtension());
                        $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'mkv']);

                        $options = [
                            'folder' => 'test-uploads',
                            'public_id' => 'test_' . uniqid(),
                            'resource_type' => $isVideo ? 'video' : 'image',
                        ];

                        if ($isVideo) {
                            $result = Cloudinary::uploadVideo($file->getRealPath(), $options);
                        } else {
                            $result = Cloudinary::upload($file->getRealPath(), $options);
                        }

                        $debug["file_{$index}"]['cloudinary_upload'] = [
                            'success' => true,
                            'url' => $result->getSecurePath(),
                            'public_id' => $result->getPublicId(),
                        ];
                    } catch (\Exception $e) {
                        $debug["file_{$index}"]['cloudinary_upload'] = [
                            'success' => false,
                            'error' => $e->getMessage(),
                        ];
                    }
                }
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

    /**
     * Debug video reviews data and playback issues
     */
    public function debugVideoReviews()
    {
        // Get all reviews with video data
        $allReviews = Review::whereNotNull('media_urls')->get();
        
        $debugInfo = [
            'total_reviews_with_media' => $allReviews->count(),
            'video_type_reviews' => Review::where('review_type', 'video')->count(),
            'sample_reviews' => [],
            'storage_info' => [
                'storage_path' => storage_path('app/public'),
                'public_storage_path' => public_path('storage'),
                'storage_link_exists' => is_link(public_path('storage')),
                'videos_directory_exists' => file_exists(storage_path('app/public/videos')),
            ]
        ];

        // Sample review data
        foreach ($allReviews->take(5) as $review) {
            $mediaUrls = is_string($review->media_urls) 
                ? json_decode($review->media_urls, true) 
                : $review->media_urls;

            $sampleData = [
                'id' => $review->id,
                'review_type' => $review->review_type,
                'media_urls_raw' => $review->media_urls,
                'media_urls_decoded' => $mediaUrls,
                'has_valid_media' => is_array($mediaUrls) && count($mediaUrls) > 0,
            ];

            // Check if video file exists
            if (is_array($mediaUrls) && count($mediaUrls) > 0) {
                $videoPath = storage_path('app/public/' . $mediaUrls[0]);
                $sampleData['video_file_exists'] = file_exists($videoPath);
                $sampleData['video_file_path'] = $videoPath;
                $sampleData['video_url'] = asset('storage/' . $mediaUrls[0]);
            }

            $debugInfo['sample_reviews'][] = $sampleData;
        }

        return response()->json($debugInfo, 200, [], JSON_PRETTY_PRINT);
    }
}
