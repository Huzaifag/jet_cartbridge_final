@extends('frontend.layout.main')
@section('content')
    <style>
        :root {
            /* Define a subtle, professional color palette */
            --primary-color: #004d40;
            /* Deep Teal/Dark Green for authority */
            --secondary-color: #388e3c;
            /* Evergreen secondary for accents */
            --accent-color: #ffb300;
            /* Amber for pricing/alerts */
            --background-color: #f8f9fa;
            /* Light grey/off-white background */
            --card-bg: #ffffff;
            --text-color: #212529;
        }

        body {
            background-color: var(--background-color);
        }

        /* --- General Card & Layout Styling --- */
        .detail-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
            /* Stronger, softer shadow */
            margin-bottom: 2.5rem;
            background-color: var(--card-bg);
            transition: box-shadow 0.3s ease;
        }

        .detail-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .card-title-pro {
            color: var(--primary-color);
            font-weight: 700;
            font-size: 1.5rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }

        /* --- Product Header (Above Fold Focus) --- */
        .product-header-pro {
            padding: 3rem 0 1rem;
            margin-bottom: 1.5rem;
        }

        .product-title-pro {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--text-color);
            line-height: 1.2;
        }

        .product-category-pro {
            font-size: 1.1rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }

        /* --- Image Slider --- */
        .product-main-image-pro {
            aspect-ratio: 16/10;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .product-main-image-pro img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            /* Changed to contain for full image visibility */
            background-color: #fff;
        }

        .product-thumbnails-pro {
            display: flex;
            gap: 10px;
            margin-top: 1rem;
            justify-content: start;
            overflow-x: auto;
            /* Allow horizontal scrolling for many thumbnails */
            padding-bottom: 5px;
        }

        .product-thumbnails-pro .thumbnail-pro {
            min-width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.2s ease;
        }

        .product-thumbnails-pro .thumbnail-pro.active {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(0, 77, 64, 0.5);
        }

        /* --- Price & Action Section (Right Column) --- */
        .price-actions-card {
            padding: 1.5rem;
        }

        .price-tag-pro {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--accent-color);
            margin-bottom: 0.25rem;
        }

        .moq-pro {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .action-btn-pro {
            width: 100%;
            margin-bottom: 0.75rem;
            padding: 0.75rem;
            border-radius: 50px;
            /* Pill shape for modern look */
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: background-color 0.3s, transform 0.1s;
        }

        .btn-primary-custom {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #00332c;
            border-color: #00332c;
            transform: translateY(-2px);
        }

        .btn-outline-primary-custom {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary-custom:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* --- Seller Info Styling --- */
        .seller-avatar-pro {
            width: 60px;
            height: 60px;
            background-color: var(--secondary-color);
            border: 4px solid var(--background-color);
            box-shadow: 0 0 0 2px var(--secondary-color);
        }

        .seller-name-pro {
            color: var(--primary-color);
            font-weight: 700;
        }

        .verified-badge {
            font-weight: 700;
            color: var(--secondary-color);
        }

        /* --- Specification & Review Tabs --- */
        .spec-item-pro {
            padding: 1rem 0;
            border-bottom: 1px dashed #e9ecef;
        }

        .spec-label-pro {
            font-weight: 600;
            color: #495057;
        }

        .nav-tabs .nav-link {
            font-weight: 600;
            color: #6c757d;
            border: none;
            border-bottom: 3px solid transparent;
            padding-bottom: 0.5rem;
            margin-right: 1.5rem;
            transition: all 0.2s;
        }

        .video-review-card-pro {
            transition: all 0.3s ease;
        }

        .video-review-card-pro:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            transform: translateY(-5px) scale(1.02);
        }

        .video-review-card-pro .card-img-top {
            object-fit: cover;
            height: 300px;
        }

        /* Stick the Buy/Contact box on desktop */
        @media (min-width: 992px) {
            .sticky-sidebar {
                align-self: flex-start;
                /* Ensures sticky behavior in the column */
            }
        }
    </style>

    <div class="product-header-pro">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p class="product-category-pro">{{ $product->category ?? 'Machinery > Manufacturing > CNC Machines' }}
                    </p>
                    <h1 class="product-title-pro">
                        {{ $product->name ?? 'Industrial CNC Milling Machine - 5 Axis Precision' }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <div class="product-images-section detail-card p-4">
                    <div class="product-slider">
                        {{-- Main Image Area - Made Sticky --}}
                        <div class="product-main-image-pro mb-3">
                            <img id="main-product-image"
                                src="{{ asset('storage/' . ($product['images'][0] ?? 'placeholder.jpg')) }}"
                                class="img-fluid" alt="{{ $product['name'] ?? 'Product Image' }}">
                        </div>

                        {{-- Thumbnails --}}
                        <div class="product-thumbnails-pro">
                            @foreach ($product['images'] as $index => $image)
                                <img class="thumbnail-pro {{ $index === 0 ? 'active' : '' }}"
                                    src="{{ asset('storage/' . $image) }}" alt="Thumbnail {{ $index + 1 }}"
                                    style="width:100px; height:100px; object-fit:cover; cursor:pointer;">
                            @endforeach
                            {{-- Placeholder for Video Thumbnail --}}
                            <div class="thumbnail-pro d-flex align-items-center justify-content-center bg-light active-video"
                                style="width:100px; height:100px; border: 1px solid #ddd; cursor:pointer;"
                                data-video-url="https://www.youtube.com/embed/dQw4w9WgXcQ">
                                <i class="fas fa-play-circle fa-2x text-primary"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5 class="card-title-pro"><i class="fas fa-video me-2"></i>Product Demonstration</h5>
                        <div class="ratio ratio-16x9 rounded-3 shadow-sm">
                            <iframe id="product-video-iframe" src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                                title="Product Video" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <div class="detail-card p-4">
                    <h5 class="card-title-pro"><i class="fas fa-list-alt me-2"></i>Technical Specifications</h5>
                    <div class="row g-3">
                        <div class="col-md-6 spec-item-pro">
                            <div class="spec-label-pro">Model Number</div>
                            <div>CNC-MILL-5AXIS-2023</div>
                        </div>
                        <div class="col-md-6 spec-item-pro">
                            <div class="spec-label-pro">Weight / Dimensions</div>
                            <div>2500 kg / 2000mm x 1500mm</div>
                        </div>
                        <div class="col-md-6 spec-item-pro">
                            <div class="spec-label-pro">Spindle Speed</div>
                            <div>0-12000 RPM (Variable)</div>
                        </div>
                        <div class="col-md-6 spec-item-pro">
                            <div class="spec-label-pro">Accuracy</div>
                            <div>$ \pm 0.005mm $</div>
                        </div>
                        <div class="col-md-6 spec-item-pro">
                            <div class="spec-label-pro">Power Supply</div>
                            <div>380V, 50Hz, 3 Phase</div>
                        </div>
                        <div class="col-md-6 spec-item-pro">
                            <div class="spec-label-pro">Warranty</div>
                            <div>2 Years (On-site Support)</div>
                        </div>
                    </div>
                </div>

                <div class="detail-card p-4">
                    <h5 class="card-title-pro"><i class="fas fa-star-half-alt me-2"></i>Customer Reviews & Content</h5>

                    <ul class="nav nav-tabs border-0 mb-4" id="reviewTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="text-image-tab" data-bs-toggle="tab"
                                data-bs-target="#text-image-reviews" type="button" role="tab" aria-selected="true">
                                <i class="fas fa-comments me-2"></i>Reviews ({{ $reviews->count() }})
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-reviews"
                                type="button" role="tab" aria-selected="false">
                                <i class="fas fa-video me-2"></i>Video Reviews (7)
                                <span class="badge bg-danger ms-1">HOT 🔥</span>
                            </button>
                        </li>
                        <li class="nav-item ms-auto" role="presentation">
                            <button class="btn btn-sm btn-outline-primary-custom" data-bs-toggle="modal"
                                data-bs-target="#submitReviewModal">
                                <i class="fas fa-pencil-alt me-1"></i>Write a Review
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- 🟢 TEXT/IMAGE REVIEWS TAB -->
                        <div class="tab-pane fade show active" id="text-image-reviews" role="tabpanel">
                            <div class="d-flex align-items-center mb-4 p-3 bg-light rounded-3">
                                <h4 class="me-3 mb-0 display-5 fw-bold">{{ $reviews->avg('rating') ?: '0.0' }}</h4>
                                <div class="rating me-3 d-flex align-items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= floor($reviews->avg('rating')))
                                            <i class="fas fa-star text-warning fa-lg"></i>
                                        @elseif ($i - 0.5 <= $reviews->avg('rating'))
                                            <i class="fas fa-star-half-alt text-warning fa-lg"></i>
                                        @else
                                            <i class="far fa-star text-warning fa-lg"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-muted small">(Based on {{ $reviews->count() }} reviews)</span>
                            </div>

                            {{-- 🟢 Only text/image reviews --}}
                            @php
                                $textImageReviews = $reviews->whereIn('review_type', ['text_image', 'text']);
                            @endphp

                            @forelse ($textImageReviews as $review)
                                <div class="border-start border-4 border-secondary ps-3 mb-4">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://via.placeholder.com/40' }}"
                                            class="rounded-circle me-3" alt="Reviewer" style="width:40px; height:40px;">
                                        <div>
                                            <h6 class="mb-0 seller-name-pro">{{ $review->user->name }}
                                                @if ($review->is_verified_purchase)
                                                    <i class="fas fa-check-circle text-success ms-1" title="Verified Purchase"></i>
                                                @endif
                                            </h6>
                                            <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                        </div>
                                    </div>
                                    <div class="rating mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="{{ $i <= $review->rating ? 'fas' : 'far' }} fa-star text-warning"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-2">{{ $review->review_text }}</p>

                                    {{-- Show review images --}}
                                    @if ($review->media_urls)
                                        <div class="review-images d-flex gap-2 flex-wrap">
                                            @foreach ($review->media_urls as $media)
                                                @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $media))
                                                    <img src="{{ asset('storage/' . $media) }}" class="img-thumbnail rounded-3"
                                                        alt="Review Image" style="max-width: 100px; max-height: 100px;">
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No text/image reviews yet</h5>
                                </div>
                            @endforelse
                        </div>

                        <!-- 🔵 VIDEO REVIEWS TAB -->
                        <div class="tab-pane fade" id="video-reviews" role="tabpanel">
                            <div class="alert alert-warning small d-flex align-items-center rounded-3 shadow-sm"
                                role="alert">
                                <i class="fas fa-coins me-2 fa-lg"></i>
                                <div class="fw-bold">
                                    **Monetized Content:** Video reviewers earn **100 Coins** when a purchase is made via
                                    their unique review link.
                                </div>
                            </div>

                            @php
                                $videoReviews = $reviews->where('review_type', 'video');
                            @endphp

                            <div class="row row-cols-2 g-3">
                                @forelse ($videoReviews as $review)
                                    <div class="col">
                                        <div class="card h-100 shadow-sm video-review-card-pro">
                                            <div class="position-relative">
                                                @if ($review->media_urls && count($review->media_urls) > 0)
                                                    <video controls class="card-img-top rounded-top-3" style="max-height: 250px;">
                                                        <source src="{{ asset('storage/' . $review->media_urls[0]) }}"
                                                            type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                @else
                                                    <img src="https://via.placeholder.com/180x300?text=No+Video"
                                                        class="card-img-top rounded-top-3" alt="No Video">
                                                @endif
                                                <span class="badge bg-danger position-absolute top-0 end-0 m-2">
                                                    <i class="fas fa-video me-1"></i>Short
                                                </span>
                                            </div>
                                            <div class="card-body p-3">
                                                <h6 class="card-title small fw-bold mb-1 text-truncate">
                                                    {{ $review->review_text }}
                                                </h6>
                                                <div
                                                    class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                                    <small class="text-muted text-truncate d-flex align-items-center">
                                                        <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://via.placeholder.com/20' }}"
                                                            class="rounded-circle me-1" style="width:20px; height:20px;">
                                                        {{ '@' . Str::slug($review->user->name, '') }}
                                                    </small>
                                                    <form action="{{ route('review.orderWithFer', $review) }}" method="post"
                                                        style="display: inline-block;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-primary py-1 px-2">
                                                            <i class="fas fa-shopping-cart me-1"></i> Buy
                                                        </button>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12 text-center py-4">
                                        <i class="fas fa-video fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No video reviews yet</h5>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="sticky-sidebar">
                    @if (auth()->check() && auth()->user()->role === 'b2b')
                        {{-- B2B User View --}}
                        <div class="detail-card price-actions-card text-center">
                            <div class="price-tag-pro">
                                ${{ $product->b2b_price ?? '45,000 - 55,000' }}
                            </div>
                            <div class="moq-pro">
                                Minimum Order Quantity (MOQ): <strong>{{ $product->moq ?? 1 }} unit</strong>
                            </div>

                            <button class="btn action-btn-pro btn-primary-custom mb-2">
                                <i class="fas fa-paper-plane me-2"></i>Send Detailed Inquiry
                            </button>
                            <button class="btn action-btn-pro btn-outline-primary-custom">
                                <i class="fas fa-comments me-2"></i>Live Chat with Agent
                            </button>

                            <div class="mt-4 border-top pt-3">
                                <small class="text-muted d-block mb-2">Alternative Contact Options</small>
                                <div class="d-flex justify-content-around">
                                    <button class="btn btn-sm btn-info text-white" title="Schedule Meeting">
                                        <i class="fas fa-calendar-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-success text-white" title="Audio Call">
                                        <i class="fas fa-phone-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger text-white" title="Video Call">
                                        <i class="fas fa-video"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Non-B2B or Guest User View --}}
                        <div class="detail-card price-actions-card text-center">
                            <div class="price-tag-pro">
                                ${{ $product->price ?? '49,999' }}
                            </div>

                            <button class="btn btn-primary-custom action-btn-pro mb-2">
                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                            </button>

                            <button class="btn btn-outline-primary-custom action-btn-pro">
                                <i class="fas fa-bolt me-2"></i>Buy Now
                            </button>
                        </div>
                    @endif


                    <div class="detail-card p-4">
                        <h5 class="card-title-pro small"><i class="fas fa-building me-2"></i>Seller Information</h5>
                        <div class="d-flex align-items-center mb-3">
                            <div
                                class="seller-avatar-pro rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0">
                                <i class="fas fa-industry text-white fa-lg"></i>
                            </div>
                            <div class="seller-details">
                                <h5 class="mb-0 seller-name-pro">
                                    {{ $product->seller->company_name ?? 'Precision Manufacturing Co.' }}
                                </h5>
                                <small class="verified-badge"><i class="fas fa-check-circle me-1"></i> Verified
                                    Supplier</small>
                            </div>
                        </div>

                        <ul class="list-unstyled small mb-3">
                            <li><i class="fas fa-map-marker-alt text-muted me-2"></i> Shanghai, China</li>
                            <li><i class="fas fa-star text-warning me-2"></i> **4.8/5.0** (127 Global Reviews)</li>
                        </ul>

                        <div class="bg-light p-3 rounded-3 mt-3">
                            <h6 class="small fw-bold text-primary mb-1">Key Contact</h6>
                            <p class="mb-0 small"><i class="fas fa-user me-2"></i> Zhang Wei (Sales Executive)</p>
                            <p class="mb-0 small"><i class="fas fa-phone me-2"></i> +86 138 0013 XXXX <a href="#"
                                    class="small ms-2 text-primary">Show Full Number</a></p>
                        </div>

                        <div class="mt-3">
                            <span class="badge rounded-pill bg-dark">Manufacturer</span>
                            <span class="badge rounded-pill bg-dark">Exporter</span>
                        </div>
                    </div>

                    <div class="detail-card p-4">
                        <h5 class="card-title-pro small"><i class="fas fa-chart-bar me-2"></i>Quick Stats</h5>
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <span class="text-muted small">Inquiries This Month:</span>
                            <strong>28</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <span class="text-muted small">Seller Response Rate:</span>
                            <strong class="text-success">98%</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Average Response Time:</span>
                            <strong class="text-primary">
                                < 2 hours</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="submitReviewModal" tabindex="-1" aria-labelledby="submitReviewModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-custom text-white" style="background-color: var(--primary-color);">
                    <h5 class="modal-title" id="submitReviewModalLabel"><i class="fas fa-pencil-alt me-2"></i>Submit Your
                        Review</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reviewForm" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="reviewRating" class="form-label">Overall Rating</label>
                            <div id="reviewRating">
                                <i class="far fa-star fa-lg text-warning me-1 star" data-rating="1"></i><i
                                    class="far fa-star fa-lg text-warning me-1 star" data-rating="2"></i><i
                                    class="far fa-star fa-lg text-warning me-1 star" data-rating="3"></i><i
                                    class="far fa-star fa-lg text-warning me-1 star" data-rating="4"></i><i
                                    class="far fa-star fa-lg text-warning me-1 star" data-rating="5"></i>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput" value="0">
                        </div>
                        <div class="mb-3">
                            <label for="reviewType" class="form-label">Review Type</label>
                            <select class="form-select" name="review_type" id="reviewType">
                                <option value="text" selected>Text Only</option>
                                <option value="text_image">Text + Images</option>
                                <option value="video">Short Video Review (Earn Coins! 💰)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reviewText" class="form-label">Review Details</label>
                            <textarea class="form-control" name="review_text" id="reviewText" rows="4"
                                placeholder="Share your experience with the product..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="reviewMedia" class="form-label">Upload Media (Images / Video)</label>
                            <input class="form-control" type="file" name="media[]" id="reviewMedia"
                                accept="image/*, video/mp4" multiple>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary-custom" id="submitReviewBtn">Post Review</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mainImage = document.getElementById('main-product-image');
            const productVideoIframe = document.getElementById('product-video-iframe');
            const thumbnails = document.querySelectorAll('.product-thumbnails-pro .thumbnail-pro');
            const videoThumbnail = document.querySelector('.product-thumbnails-pro .active-video');
            const defaultImageSrc = mainImage.src;
            const defaultVideoSrc = productVideoIframe.src;

            // Function to reset the main area to display an image
            function showImage(src) {
                mainImage.src = src;
                mainImage.style.display = 'block';
                productVideoIframe.parentNode.style.display = 'none';
            }

            // Function to set the main area to display a video
            function showVideo(url) {
                // Stop any video that might be playing if this logic were more advanced
                productVideoIframe.src = url;
                mainImage.style.display = 'none';
                productVideoIframe.parentNode.style.display = 'block';
            }

            // Initialize: hide video iframe and show default image
            if (productVideoIframe) {
                productVideoIframe.parentNode.style.display = 'none';
            }

            thumbnails.forEach(thumbnail => {
                thumbnail.addEventListener('click', function () {
                    // Remove 'active' class from all thumbnails and video selector
                    document.querySelectorAll('.product-thumbnails-pro > *').forEach(t => t
                        .classList.remove('active'));

                    // Add 'active' class to the clicked thumbnail
                    this.classList.add('active');

                    // Update the main image source
                    showImage(this.src);
                });
            });

            // Video Thumbnail Click Handler
            if (videoThumbnail) {
                videoThumbnail.addEventListener('click', function () {
                    // Remove 'active' class from all thumbnails and image selector
                    document.querySelectorAll('.product-thumbnails-pro > *').forEach(t => t.classList
                        .remove('active'));

                    // Add 'active' class to the clicked element
                    this.classList.add('active');

                    // Switch to video view
                    const videoUrl = this.dataset.videoUrl;
                    showVideo(videoUrl);
                });
            }

            // Star Rating Functionality
            const stars = document.querySelectorAll('#reviewRating .star');
            const ratingInput = document.getElementById('ratingInput');

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingInput.value = rating;

                    // Update star display
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });

                star.addEventListener('mouseover', function () {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });

                star.addEventListener('mouseout', function () {
                    const currentRating = parseInt(ratingInput.value);
                    stars.forEach((s, index) => {
                        if (index < currentRating) {
                            s.classList.remove('far');
                            s.classList.add('fas');
                        } else {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });
            });

            // Review Form Submission
            const reviewForm = document.getElementById('reviewForm');
            const submitReviewBtn = document.getElementById('submitReviewBtn');

            submitReviewBtn.addEventListener('click', function (e) {
                e.preventDefault();

                const formData = new FormData(reviewForm);

                // Disable button to prevent multiple submissions
                submitReviewBtn.disabled = true;
                submitReviewBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';

                fetch('/product/{{ $product->slug }}/review', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Close modal
                            const modal = bootstrap.Modal.getInstance(document.getElementById('submitReviewModal'));
                            modal.hide();

                            // Reset form
                            reviewForm.reset();
                            document.querySelectorAll('#reviewRating .star').forEach(star => {
                                star.classList.remove('fas');
                                star.classList.add('far');
                            });
                            document.getElementById('ratingInput').value = '0';

                            // Show success message
                            alert(data.message);

                            // Optionally reload the page to show the new review
                            location.reload();
                        } else {
                            // Show errors
                            let errorMessage = 'Please fix the following errors:\n';
                            if (data.errors) {
                                for (let field in data.errors) {
                                    errorMessage += data.errors[field].join('\n') + '\n';
                                }
                            } else {
                                errorMessage = data.message;
                            }
                            alert(errorMessage);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while submitting your review. Please try again.');
                    })
                    .finally(() => {
                        // Re-enable button
                        submitReviewBtn.disabled = false;
                        submitReviewBtn.innerHTML = '<i class="fas fa-pencil-alt me-2"></i>Post Review';
                    });
            });
        });
    </script>
@endsection