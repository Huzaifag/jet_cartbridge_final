<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Video Reviews - {{ config('app.name') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        margin: 0;
        padding: 0;
        overflow: hidden;
        background: #000;
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    }

    .reels-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        overflow-y: scroll;
        scroll-snap-type: y mandatory;
        scrollbar-width: none;
        z-index: 999999;
        background: #000;
    }

    .reels-container::-webkit-scrollbar {
        display: none;
    }

    .reel-item {
        position: relative;
        width: 100%;
        height: 100vh;
        scroll-snap-align: start;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #000;
    }

    .reel-video {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background: #000;
    }

    /* Overlay Controls */
    .reel-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, transparent 20%, transparent 80%, rgba(0,0,0,0.5) 100%);
    }

    /* Top Bar */
    .reel-top-bar {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        padding: 1rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        pointer-events: all;
        z-index: 10;
    }

    .reel-logo {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .reel-close-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
        cursor: pointer;
        transition: all 0.3s;
    }

    .reel-close-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }

    /* Bottom Info */
    .reel-info {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 90px;
        padding: 1.5rem;
        padding-bottom: 2rem;
        color: white;
        pointer-events: all;
        z-index: 10;
        max-height: 40vh;
        overflow: hidden;
    }

    .reel-user {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
        flex-wrap: wrap;
    }

    .reel-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 2px solid white;
        object-fit: cover;
        flex-shrink: 0;
    }

    .reel-username {
        font-weight: 600;
        font-size: 1rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        flex: 1;
        min-width: 0;
    }

    .reel-follow-btn {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border: 2px solid white;
        color: white;
        padding: 0.4rem 1.2rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }

    .reel-follow-btn:hover {
        background: white;
        color: #000;
        transform: scale(1.05);
    }

    .reel-follow-btn.following {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .reel-description {
        font-size: 0.95rem;
        line-height: 1.4;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        max-height: 60px;
        overflow: hidden;
    }

    .reel-product-tag {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .reel-product-tag:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
    }

    /* Right Action Bar */
    .reel-actions {
        position: absolute;
        right: 0.75rem;
        bottom: 8rem;
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        pointer-events: all;
        z-index: 15;
        align-items: center;
    }

    .reel-action-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        border: none;
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0.5rem;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        justify-content: center;
    }

    .reel-action-btn i {
        font-size: 1.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));
        transition: all 0.3s;
    }

    .reel-action-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: scale(1.1);
    }

    .reel-action-btn:hover i {
        transform: scale(1.1);
    }

    .reel-action-btn.liked {
        background: rgba(255, 68, 88, 0.2);
    }

    .reel-action-btn.liked i {
        color: #ff4458;
    }

    .reel-action-count {
        font-size: 0.7rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        margin-top: -0.25rem;
    }

    .reel-buy-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.25rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        backdrop-filter: blur(10px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        color: white;
        cursor: pointer;
        transition: all 0.3s;
        padding: 0.5rem;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.6);
        animation: pulse 2s infinite;
        position: relative;
    }

    .reel-buy-btn::before {
        content: '';
        position: absolute;
        top: -2px;
        right: -2px;
        width: 12px;
        height: 12px;
        background: #ff4458;
        border-radius: 50%;
        border: 2px solid white;
        animation: ping 2s cubic-bezier(0, 0, 0.2, 1) infinite;
    }

    @keyframes ping {
        75%, 100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }

    .reel-buy-btn i {
        font-size: 1.5rem;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.8));
        transition: all 0.3s;
    }

    .reel-buy-btn:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3d8f 100%);
        transform: scale(1.1);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.8);
    }

    .reel-buy-btn:hover i {
        transform: scale(1.1);
    }

    .reel-buy-label {
        font-size: 0.7rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0,0,0,0.8);
        margin-top: -0.25rem;
    }

    @keyframes pulse {
        0%, 100% {
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.6);
        }
        50% {
            box-shadow: 0 4px 25px rgba(102, 126, 234, 0.9);
        }
    }

    /* Play/Pause Indicator */
    .play-pause-indicator {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 4rem;
        color: white;
        opacity: 0;
        transition: opacity 0.3s;
        pointer-events: none;
        z-index: 5;
    }

    .play-pause-indicator.show {
        opacity: 0.8;
    }

    /* Comments Modal - Side Panel */
    .comments-modal {
        position: fixed;
        right: -100%;
        top: 0;
        width: 400px;
        max-width: 90vw;
        height: 100vh;
        background: white;
        transition: right 0.3s ease;
        z-index: 999999;
        display: flex;
        flex-direction: column;
        box-shadow: -4px 0 20px rgba(0, 0, 0, 0.3);
    }

    .comments-modal.show {
        right: 0;
    }

    .comments-header {
        padding: 1.5rem 1rem;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: white;
    }

    .comments-header h5 {
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }

    .comments-body {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
        background: #f8f9fa;
    }

    .comment-item {
        display: flex;
        gap: 0.75rem;
        margin-bottom: 1rem;
        padding: 0.75rem;
        background: white;
        border-radius: 12px;
        transition: all 0.3s;
    }

    .comment-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .comment-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }

    .comment-content {
        flex: 1;
        min-width: 0;
    }

    .comment-username {
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.25rem;
        color: #212529;
    }

    .comment-text {
        font-size: 0.875rem;
        color: #495057;
        word-wrap: break-word;
    }

    .comment-time {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .comments-input {
        padding: 1rem;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 0.5rem;
        background: white;
    }

    .comments-input input {
        flex: 1;
        border: 1px solid #e9ecef;
        border-radius: 25px;
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.3s;
    }

    .comments-input input:focus {
        border-color: #667eea;
    }

    .comments-input button {
        background: #667eea;
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .comments-input button:hover {
        background: #5568d3;
        transform: scale(1.05);
    }

    .comments-input button:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
    }

    /* Share Modal - Side Panel */
    .share-modal {
        position: fixed;
        right: -100%;
        top: 0;
        width: 400px;
        max-width: 90vw;
        height: 100vh;
        background: white;
        transition: right 0.3s ease;
        z-index: 999999;
        padding: 2rem;
        box-shadow: -4px 0 20px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
    }

    .share-modal.show {
        right: 0;
    }

    .share-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
    }

    .share-modal h5 {
        font-weight: 700;
        font-size: 1.1rem;
        margin: 0;
    }

    .share-options {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-top: 1rem;
    }

    .share-option {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s;
        border-radius: 12px;
        background: #f8f9fa;
    }

    .share-option:hover {
        background: #e9ecef;
        transform: translateX(5px);
    }

    .share-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        color: white;
        flex-shrink: 0;
    }

    .share-label {
        font-size: 0.95rem;
        font-weight: 600;
        color: #212529;
        flex: 1;
    }

    /* Loading Spinner */
    .loading-spinner {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: 2rem;
    }

    /* Modal Backdrop */
    .modal-backdrop-custom {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999998;
        display: none;
        backdrop-filter: blur(3px);
        transition: opacity 0.3s ease;
    }

    .modal-backdrop-custom.show {
        display: block;
        opacity: 1;
    }

    /* Responsive */
    @media (min-width: 768px) {
        .reels-container {
            max-width: 500px;
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        /* Mobile: Slide from bottom */
        .comments-modal,
        .share-modal {
            right: auto;
            left: 0;
            bottom: -100%;
            top: auto;
            width: 100%;
            max-width: 100%;
            height: 75vh;
            max-height: 600px;
            border-radius: 20px 20px 0 0;
            box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.3);
            transition: bottom 0.3s ease;
        }

        .comments-modal.show,
        .share-modal.show {
            bottom: 0;
            right: auto;
        }

        .comments-modal::before,
        .share-modal::before {
            content: '';
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 4px;
            background: #dee2e6;
            border-radius: 2px;
        }

        .share-options {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 576px) {
        .reel-info {
            right: 70px;
            padding: 1rem;
        }

        .reel-actions {
            right: 0.5rem;
            bottom: 6rem;
            gap: 1rem;
        }

        .reel-action-btn {
            width: 45px;
            height: 45px;
        }

        .reel-action-btn i {
            font-size: 1.3rem;
        }

        .reel-buy-btn {
            width: 45px;
            height: 45px;
        }

        .reel-buy-btn i {
            font-size: 1.3rem;
        }

        .reel-buy-label {
            font-size: 0.65rem;
        }
    }
</style>

<div class="reels-container" id="reelsContainer">
    @foreach($videoReviews as $index => $review)
    <div class="reel-item" data-review-id="{{ $review->id }}" data-index="{{ $index }}">
        <!-- Video -->
        <video 
            class="reel-video" 
            src="{{ $review->media_urls[0] }}"
            loop
            playsinline
            {{ $index === 0 ? 'autoplay' : '' }}
            muted="{{ $index === 0 ? 'true' : 'false' }}"
        ></video>

        <!-- Loading Spinner -->
        <div class="loading-spinner">
            <i class="fas fa-spinner fa-spin"></i>
        </div>

        <!-- Play/Pause Indicator -->
        <div class="play-pause-indicator">
            <i class="fas fa-play"></i>
        </div>

        <!-- Overlay -->
        <div class="reel-overlay">
            <!-- Top Bar -->
            <div class="reel-top-bar">
                <div class="reel-logo">
                    <i class="fas fa-video me-2"></i>Reviews
                </div>
                <button class="reel-close-btn" onclick="window.history.back()">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Bottom Info -->
            <div class="reel-info">
                <div class="reel-user">
                    <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://via.placeholder.com/40' }}" 
                         alt="{{ $review->user->name }}" 
                         class="reel-avatar">
                    <span class="reel-username">{{ '@' . Str::slug($review->user->name, '') }}</span>
                    @if(auth()->check() && auth()->id() !== $review->user_id)
                        <button class="reel-follow-btn ms-auto">Follow</button>
                    @endif
                </div>
                <div class="reel-description">
                    {{ $review->review_text }}
                </div>
                <div class="reel-product-tag" onclick="window.location.href='{{ route('product.show', $review->product->slug) }}'">
                    <i class="fas fa-tag"></i>
                    {{ Str::limit($review->product->name, 30) }}
                </div>
            </div>

            <!-- Right Actions -->
            <div class="reel-actions">
                <!-- Like -->
                <button class="reel-action-btn like-btn" data-review-id="{{ $review->id }}">
                    <i class="fas fa-heart"></i>
                    <span class="reel-action-count">{{ $review->video_likes ?? 0 }}</span>
                </button>

                <!-- Comment -->
                <button class="reel-action-btn comment-btn" data-review-id="{{ $review->id }}">
                    <i class="fas fa-comment"></i>
                    <span class="reel-action-count">0</span>
                </button>

                <!-- Share -->
                <button class="reel-action-btn share-btn" data-review-id="{{ $review->id }}">
                    <i class="fas fa-share"></i>
                    <span class="reel-action-count">Share</span>
                </button>

                <!-- Buy -->
                <form action="{{ route('review.orderWithFer', $review) }}" method="post" style="margin: 0;">
                    @csrf
                    <button type="submit" class="reel-buy-btn">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="reel-buy-label">Buy</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal Backdrop -->
<div class="modal-backdrop-custom" id="modalBackdrop" onclick="closeAllModals()"></div>

<!-- Comments Modal -->
<div class="comments-modal" id="commentsModal">
    <div class="comments-header">
        <h5 class="mb-0">Comments</h5>
        <button class="btn-close" onclick="closeCommentsModal()"></button>
    </div>
    <div class="comments-body" id="commentsBody">
        <!-- Comments will be loaded here -->
    </div>
    <div class="comments-input">
        <input type="text" id="commentInput" placeholder="Add a comment...">
        <button onclick="postComment()">Post</button>
    </div>
</div>

<!-- Share Modal -->
<div class="share-modal" id="shareModal">
    <div class="share-modal-header">
        <h5>Share this review</h5>
        <button class="btn-close" onclick="closeShareModal()"></button>
    </div>
    <div class="share-options">
        <div class="share-option" onclick="shareVia('whatsapp')">
            <div class="share-icon" style="background: #25D366;">
                <i class="fab fa-whatsapp"></i>
            </div>
            <span class="share-label">WhatsApp</span>
        </div>
        <div class="share-option" onclick="shareVia('facebook')">
            <div class="share-icon" style="background: #1877F2;">
                <i class="fab fa-facebook-f"></i>
            </div>
            <span class="share-label">Facebook</span>
        </div>
        <div class="share-option" onclick="shareVia('twitter')">
            <div class="share-icon" style="background: #1DA1F2;">
                <i class="fab fa-twitter"></i>
            </div>
            <span class="share-label">Twitter</span>
        </div>
        <div class="share-option" onclick="shareVia('copy')">
            <div class="share-icon" style="background: #6c757d;">
                <i class="fas fa-link"></i>
            </div>
            <span class="share-label">Copy Link</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('reelsContainer');
    const reels = document.querySelectorAll('.reel-item');
    let currentIndex = 0;
    let currentReviewId = null;

    // Initialize first video
    playVideo(0);

    // Scroll detection
    container.addEventListener('scroll', debounce(function() {
        const scrollTop = container.scrollTop;
        const windowHeight = window.innerHeight;
        const newIndex = Math.round(scrollTop / windowHeight);
        
        if (newIndex !== currentIndex) {
            pauseVideo(currentIndex);
            currentIndex = newIndex;
            playVideo(currentIndex);
        }
    }, 100));

    // Play/Pause on tap
    reels.forEach((reel, index) => {
        const video = reel.querySelector('.reel-video');
        const indicator = reel.querySelector('.play-pause-indicator');
        
        video.addEventListener('click', function() {
            if (video.paused) {
                video.play();
                showIndicator(indicator, 'play');
            } else {
                video.pause();
                showIndicator(indicator, 'pause');
            }
        });

        // Hide loading spinner when video loads
        video.addEventListener('loadeddata', function() {
            reel.querySelector('.loading-spinner').style.display = 'none';
        });

        // Track views
        video.addEventListener('play', function() {
            if (index === currentIndex) {
                trackView(reel.dataset.reviewId);
            }
        });
    });

    // Like button
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const reviewId = this.dataset.reviewId;
            toggleLike(reviewId, this);
        });
    });

    // Comment button
    document.querySelectorAll('.comment-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentReviewId = this.dataset.reviewId;
            openCommentsModal(currentReviewId);
        });
    });

    // Share button
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            currentReviewId = this.dataset.reviewId;
            openShareModal(currentReviewId);
        });
    });

    function playVideo(index) {
        if (reels[index]) {
            const video = reels[index].querySelector('.reel-video');
            video.muted = false;
            video.play().catch(e => console.log('Play error:', e));
        }
    }

    function pauseVideo(index) {
        if (reels[index]) {
            const video = reels[index].querySelector('.reel-video');
            video.pause();
        }
    }

    function showIndicator(indicator, type) {
        const icon = indicator.querySelector('i');
        icon.className = type === 'play' ? 'fas fa-play' : 'fas fa-pause';
        indicator.classList.add('show');
        setTimeout(() => indicator.classList.remove('show'), 500);
    }

    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function trackView(reviewId) {
        fetch(`/api/reviews/${reviewId}/view`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    }

    function toggleLike(reviewId, btn) {
        const icon = btn.querySelector('i');
        const count = btn.querySelector('.reel-action-count');
        const isLiked = btn.classList.contains('liked');

        fetch(`/api/reviews/${reviewId}/like`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                btn.classList.toggle('liked');
                count.textContent = data.likes;
                
                // Animation
                icon.style.transform = 'scale(1.3)';
                setTimeout(() => icon.style.transform = 'scale(1)', 200);
            }
        });
    }
});

function openCommentsModal(reviewId) {
    const modal = document.getElementById('commentsModal');
    const backdrop = document.getElementById('modalBackdrop');
    modal.classList.add('show');
    backdrop.classList.add('show');
    loadComments(reviewId);
    
    // Pause video when modal opens
    const currentVideo = document.querySelector('.reel-item:nth-child(' + (currentIndex + 1) + ') .reel-video');
    if (currentVideo) currentVideo.pause();
}

function closeCommentsModal() {
    const modal = document.getElementById('commentsModal');
    const backdrop = document.getElementById('modalBackdrop');
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    // Resume video when modal closes
    const currentVideo = document.querySelector('.reel-item:nth-child(' + (currentIndex + 1) + ') .reel-video');
    if (currentVideo) currentVideo.play();
}

function loadComments(reviewId) {
    // Load comments via AJAX
    fetch(`/api/reviews/${reviewId}/comments`)
        .then(response => response.json())
        .then(data => {
            const body = document.getElementById('commentsBody');
            body.innerHTML = data.comments.map(comment => `
                <div class="comment-item">
                    <img src="${comment.user.avatar || 'https://via.placeholder.com/36'}" class="comment-avatar">
                    <div class="comment-content">
                        <div class="comment-username">${comment.user.name}</div>
                        <div class="comment-text">${comment.text}</div>
                    </div>
                </div>
            `).join('');
        });
}

function postComment() {
    const input = document.getElementById('commentInput');
    const text = input.value.trim();
    
    if (!text) return;
    
    // Post comment via AJAX
    fetch(`/api/reviews/${currentReviewId}/comments`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ text })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            input.value = '';
            loadComments(currentReviewId);
        }
    });
}

function openShareModal(reviewId) {
    currentReviewId = reviewId;
    const modal = document.getElementById('shareModal');
    const backdrop = document.getElementById('modalBackdrop');
    modal.classList.add('show');
    backdrop.classList.add('show');
    
    // Pause video when modal opens
    const currentVideo = document.querySelector('.reel-item:nth-child(' + (currentIndex + 1) + ') .reel-video');
    if (currentVideo) currentVideo.pause();
}

function closeShareModal() {
    const modal = document.getElementById('shareModal');
    const backdrop = document.getElementById('modalBackdrop');
    modal.classList.remove('show');
    backdrop.classList.remove('show');
    
    // Resume video when modal closes
    const currentVideo = document.querySelector('.reel-item:nth-child(' + (currentIndex + 1) + ') .reel-video');
    if (currentVideo) currentVideo.play();
}

function closeAllModals() {
    closeCommentsModal();
    closeShareModal();
}

function shareVia(platform) {
    const url = `${window.location.origin}/video-reviews/${currentReviewId}`;
    const text = 'Check out this amazing product review!';
    
    // Track share
    fetch(`/api/reviews/${currentReviewId}/share`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ platform })
    });
    
    switch(platform) {
        case 'whatsapp':
            window.open(`https://wa.me/?text=${encodeURIComponent(text + ' ' + url)}`);
            break;
        case 'facebook':
            window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`);
            break;
        case 'twitter':
            window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`);
            break;
        case 'copy':
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
                closeShareModal();
            });
            break;
    }
    
    closeShareModal();
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
