@extends('frontend.layout.main')

@push('styles')
<style>
/* Video Reviews - TikTok/Instagram Reels Style */
.video-reviews-container {
    background: #000;
    min-height: 90vh;
    overflow: hidden;
    position: relative;
    max-width: 600px;
    margin: 0 auto;
}

.video-feed {
    height: 100vh;
    overflow-y: scroll;
    scroll-snap-type: y mandatory;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.video-feed::-webkit-scrollbar {
    display: none;
}

.video-item {
    height: 70vh;
    width: 100%;
    position: relative;
    scroll-snap-align: start;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 15vh auto;
}

.video-player {
    width: 90%;
    height: 70vh;
    object-fit: cover;
    position: relative;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

.video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(
        to bottom,
        rgba(0,0,0,0.3) 0%,
        rgba(0,0,0,0) 20%,
        rgba(0,0,0,0) 80%,
        rgba(0,0,0,0.7) 100%
    );
    z-index: 2;
    pointer-events: none;
}

.video-controls {
    position: absolute;
    right: 20px;
    bottom: 100px;
    z-index: 10;
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: center;
}

.control-btn {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.3);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
}

.control-btn:hover {
    background: rgba(255,255,255,0.3);
    transform: scale(1.1);
}

.control-btn.liked {
    color: #ff3040;
    background: rgba(255,48,64,0.2);
}

.control-count {
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    margin-top: 5px;
    text-align: center;
}

.video-info {
    position: absolute;
    left: 20px;
    bottom: 100px;
    right: 100px;
    z-index: 10;
    color: white;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.reviewer-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid white;
    object-fit: cover;
}

.reviewer-name {
    font-weight: 600;
    font-size: 1rem;
}

.follow-btn {
    background: #ff3040;
    color: white;
    border: none;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    margin-left: auto;
}

.review-text {
    font-size: 0.9rem;
    line-height: 1.4;
    margin-bottom: 10px;
    max-height: 60px;
    overflow: hidden;
}

.product-info {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(0,0,0,0.5);
    backdrop-filter: blur(10px);
    padding: 10px;
    border-radius: 10px;
    margin-top: 10px;
}

.product-thumbnail {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    object-fit: cover;
}

.product-details {
    flex: 1;
}

.product-name {
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 2px;
}

.product-price {
    font-size: 0.7rem;
    color: #ffd700;
}

.buy-now-btn {
    background: #00d4aa;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
}

.video-progress {
    position: absolute;
    left: 0;
    bottom: 0;
    height: 3px;
    background: rgba(255,255,255,0.3);
    z-index: 10;
    width: 100%;
}

.progress-bar {
    height: 100%;
    background: white;
    width: 0%;
    transition: width 0.1s linear;
}

.play-pause-overlay {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 5;
    pointer-events: none;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.play-pause-overlay.show {
    opacity: 1;
}

.play-pause-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(255,255,255,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #333;
}

.comments-panel {
    position: fixed;
    bottom: -100%;
    left: 0;
    right: 0;
    height: 60vh;
    background: white;
    border-radius: 20px 20px 0 0;
    z-index: 100;
    transition: bottom 0.3s ease;
    overflow: hidden;
}

.comments-panel.show {
    bottom: 0;
}

.comments-header {
    padding: 20px;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.comments-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.close-comments {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
}

.comments-list {
    padding: 20px;
    height: calc(60vh - 140px);
    overflow-y: auto;
}

.comment-item {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.comment-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    object-fit: cover;
}

.comment-content {
    flex: 1;
}

.comment-author {
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 2px;
}

.comment-text {
    font-size: 0.9rem;
    color: #333;
    margin-bottom: 5px;
}

.comment-time {
    font-size: 0.7rem;
    color: #666;
}

.comment-input-container {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    background: white;
    border-top: 1px solid #eee;
    display: flex;
    gap: 10px;
    align-items: center;
}

.comment-input {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 25px;
    padding: 10px 15px;
    font-size: 0.9rem;
}

.send-comment-btn {
    background: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.loading-spinner {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 5;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid rgba(255,255,255,0.3);
    border-top: 4px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.video-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: 1;
}

.video-error {
    color: white;
    text-align: center;
}

.video-player {
    width: 100%;
    height: 100%;
    object-fit: cover;
    position: absolute;
    top: 0;
    left: 0;
    background: #000;
}

/* Loading state improvements */
.video-item.loading .video-overlay {
    background: rgba(0,0,0,0.7);
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .video-item {
        height: 60vh;
        margin: 20vh auto;
    }
    
    .video-player {
        width: 95%;
        height: 60vh;
    }
    
    .video-controls {
        right: 15px;
        bottom: 80px;
        gap: 15px;
    }
    
    .control-btn {
        width: 45px;
        height: 45px;
        font-size: 1.1rem;
    }
    
    .video-info {
        left: 15px;
        bottom: 80px;
        right: 80px;
    }
    
    .reviewer-info {
        margin-bottom: 10px;
    }
    
    .reviewer-avatar {
        width: 35px;
        height: 35px;
    }
    
    .reviewer-name {
        font-size: 0.9rem;
    }
    
    .review-text {
        font-size: 0.8rem;
        max-height: 50px;
    }
}

/* Landscape mobile */
@media (max-width: 768px) and (orientation: landscape) {
    .video-item {
        height: 80vh;
        margin: 10vh auto;
    }
    
    .video-player {
        width: 85%;
        height: 80vh;
    }
    
    .video-controls {
        bottom: 60px;
        gap: 10px;
    }
    
    .control-btn {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
    
    .video-info {
        bottom: 60px;
        right: 70px;
    }
}
</style>
@endpush
@section('content')
<div class="video-reviews-container">
    <div class="video-feed" id="videoFeed">
        @forelse($videoReviews as $index => $review)
            <div class="video-item" data-review-id="{{ $review->id }}" data-index="{{ $index }}">
                <!-- Video Player -->
                @if($review->media_urls && count($review->media_urls) > 0)
                    <!-- Debug: Show video URL -->
                    {{-- <div style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.8); color: white; padding: 5px; font-size: 12px; z-index: 1000;">
                        Video URL: {{ $review->media_urls[0] }}
                    </div> --}}
                    
                    <video 
                        controls 
                        class="video-player" 
                        id="video-{{ $review->id }}"
                        loop 
                        muted
                        playsinline
                        style="width: 90%; height: 70vh; object-fit: cover; border-radius: 15px;"
                    >
                        <source src="{{ $review->media_urls[0] }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="video-placeholder d-flex flex-column align-items-center justify-content-center h-100">
                        <i class="fas fa-video fa-3x text-white mb-3"></i>
                        <p class="text-white mt-2">Video not available</p>
                        <small class="text-white-50">No media URLs found</small>
                    </div>
                @endif

                <!-- Video Overlay -->
                <div class="video-overlay"></div>

                <!-- Loading Spinner -->
                <div class="loading-spinner" id="loading-{{ $review->id }}" style="display: none;">
                    <div class="spinner"></div>
                </div>

                <!-- Play/Pause Overlay -->
                <div class="play-pause-overlay" id="playPause-{{ $review->id }}">
                    <div class="play-pause-icon">
                        <i class="fas fa-play" id="playPauseIcon-{{ $review->id }}"></i>
                    </div>
                </div>

                <!-- Video Progress -->
                <div class="video-progress">
                    <div class="progress-bar" id="progress-{{ $review->id }}"></div>
                </div>

                <!-- Video Controls -->
                <div class="video-controls">
                    <!-- Like Button -->
                    <div class="control-item">
                        <button class="control-btn like-btn" data-review-id="{{ $review->id }}">
                            <i class="fas fa-heart"></i>
                        </button>
                        <div class="control-count">{{ $review->video_likes ?? 0 }}</div>
                    </div>

                    <!-- Comment Button -->
                    <div class="control-item">
                        <button class="control-btn comment-btn" data-review-id="{{ $review->id }}">
                            <i class="fas fa-comment"></i>
                        </button>
                        <div class="control-count">{{ $review->comments_count ?? 0 }}</div>
                    </div>

                    <!-- Share Button -->
                    <div class="control-item">
                        <button class="control-btn share-btn" data-review-id="{{ $review->id }}">
                            <i class="fas fa-share"></i>
                        </button>
                        <div class="control-count">Share</div>
                    </div>

                    <!-- View Count -->
                    <div class="control-item">
                        <div class="control-btn">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="control-count">{{ $review->video_views ?? 0 }}</div>
                    </div>
                </div>

                <!-- Video Information -->
                <div class="video-info">
                    <!-- Reviewer Info -->
                    <div class="reviewer-info">
                        <img src="{{ $review->user->avatar ? asset('storage/' . $review->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($review->user->name) . '&background=007bff&color=ffffff&size=40' }}" 
                             alt="{{ $review->user->name }}" class="reviewer-avatar">
                        <span class="reviewer-name">{{ '@' . Str::slug($review->user->name, '') }}</span>
                        <button class="follow-btn">Follow</button>
                    </div>

                    <!-- Review Text -->
                    <div class="review-text">
                        {{ $review->review_text }}
                    </div>

                    <!-- Product Information -->
                    @if($review->product)
                        <div class="product-info">
                            @php
                                $productImage = 'placeholder.jpg';
                                if ($review->product->images && is_array($review->product->images) && count($review->product->images) > 0) {
                                    $productImage = $review->product->images[0];
                                }
                            @endphp
                            <img src="{{ asset($productImage) }}" alt="{{ $review->product->name }}" class="product-thumbnail">
                            <div class="product-details">
                                <div class="product-name">{{ Str::limit($review->product->name, 30) }}</div>
                                <div class="product-price">${{ number_format($review->product->b2b_price ?? 0, 2) }}</div>
                            </div>
                            <form action="{{ route('review.orderWithFer', $review) }}" method="post" style="display: inline;">
                                @csrf
                                <button type="submit" class="buy-now-btn">
                                    Buy Now
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="video-item">
                <div class="text-center text-white">
                    <i class="fas fa-video fa-4x mb-3"></i>
                    <h3>No Video Reviews Yet</h3>
                    <p>Be the first to share a video review!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<!-- Comments Panel -->
<div class="comments-panel" id="commentsPanel">
    <div class="comments-header">
        <h3 class="comments-title">Comments</h3>
        <button class="close-comments" onclick="closeComments()">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="comments-list" id="commentsList">
        <!-- Comments will be loaded here -->
    </div>
    <div class="comment-input-container">
        <input type="text" class="comment-input" id="commentInput" placeholder="Add a comment...">
        <button class="send-comment-btn" onclick="postComment()">
            <i class="fas fa-paper-plane"></i>
        </button>
    </div>
</div>
@endsection
@push('scripts')
<script>
class VideoReviewsPlayer {
    constructor() {
        this.currentIndex = 0;
        this.videos = document.querySelectorAll('.video-player');
        this.videoItems = document.querySelectorAll('.video-item');
        this.videoFeed = document.getElementById('videoFeed');
        this.isPlaying = false;
        this.currentVideo = null;
        this.currentReviewId = null;
        
        this.init();
    }

    init() {
        this.setupScrollListener();
        this.setupVideoControls();
        this.setupInteractionButtons();
        this.playCurrentVideo();
        
        // Track initial view
        if (this.videoItems.length > 0) {
            this.trackView(this.videoItems[0].dataset.reviewId);
        }
    }

    setupScrollListener() {
        let scrollTimeout;
        
        this.videoFeed.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                this.handleScroll();
            }, 100);
        });
    }

    handleScroll() {
        const scrollTop = this.videoFeed.scrollTop;
        const itemHeight = window.innerHeight;
        const newIndex = Math.round(scrollTop / itemHeight);
        
        if (newIndex !== this.currentIndex && newIndex >= 0 && newIndex < this.videoItems.length) {
            this.pauseCurrentVideo();
            this.currentIndex = newIndex;
            this.playCurrentVideo();
            
            // Track view for new video
            const reviewId = this.videoItems[this.currentIndex].dataset.reviewId;
            this.trackView(reviewId);
        }
    }

    playCurrentVideo() {
        if (this.currentIndex >= 0 && this.currentIndex < this.videos.length) {
            this.currentVideo = this.videos[this.currentIndex];
            this.currentReviewId = this.videoItems[this.currentIndex].dataset.reviewId;
            
            if (this.currentVideo) {
                // Pause all other videos first
                this.videos.forEach(video => {
                    if (video !== this.currentVideo) {
                        video.pause();
                    }
                });

                // Reset current video
                this.currentVideo.currentTime = 0;
                
                // Simple play attempt
                const playPromise = this.currentVideo.play();
                
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        console.log('Video playing successfully');
                        this.isPlaying = true;
                        this.updateProgress();
                    }).catch(error => {
                        console.log('Autoplay prevented:', error);
                        this.isPlaying = false;
                        // Don't show error, just let user click to play
                    });
                }

                // Handle video end
                this.currentVideo.onended = () => {
                    this.currentVideo.currentTime = 0;
                    if (this.isPlaying) {
                        this.currentVideo.play();
                    }
                };
            }
        }
    }

    setupUserInteractionPlay() {
        const playOnInteraction = () => {
            if (this.currentVideo && !this.isPlaying) {
                this.currentVideo.play().then(() => {
                    this.isPlaying = true;
                    this.updateProgress();
                    document.removeEventListener('click', playOnInteraction);
                    document.removeEventListener('touchstart', playOnInteraction);
                }).catch(error => {
                    console.error('Failed to play video on interaction:', error);
                });
            }
        };

        document.addEventListener('click', playOnInteraction, { once: true });
        document.addEventListener('touchstart', playOnInteraction, { once: true });
    }

    showVideoError(reviewId) {
        const videoItem = document.querySelector(`[data-review-id="${reviewId}"]`);
        if (videoItem) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'video-error d-flex flex-column align-items-center justify-content-center h-100 position-absolute';
            errorDiv.style.cssText = 'top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 3;';
            errorDiv.innerHTML = `
                <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
                <p class="text-white mb-2">Video failed to load</p>
                <small class="text-white-50">Please check your internet connection</small>
                <button class="btn btn-primary btn-sm mt-3" onclick="window.videoPlayer.retryVideo('${reviewId}')">
                    <i class="fas fa-redo me-1"></i> Retry
                </button>
            `;
            videoItem.appendChild(errorDiv);
        }
    }

    retryVideo(reviewId) {
        // Remove error message
        const errorDiv = document.querySelector(`[data-review-id="${reviewId}"] .video-error`);
        if (errorDiv) {
            errorDiv.remove();
        }

        // Retry playing the video
        const video = document.getElementById(`video-${reviewId}`);
        if (video) {
            this.showLoading(reviewId);
            video.load();
        }
    }

    pauseCurrentVideo() {
        if (this.currentVideo) {
            this.currentVideo.pause();
            this.isPlaying = false;
        }
    }

    setupVideoControls() {
        this.videoItems.forEach((item, index) => {
            const video = item.querySelector('.video-player');
            
            if (video) {
                // Click to play/pause
                video.addEventListener('click', (e) => {
                    // Let the native controls handle the click
                    // e.preventDefault();
                    // this.togglePlayPause();
                });

                // Update our tracking when video plays/pauses
                video.addEventListener('play', () => {
                    this.isPlaying = true;
                });

                video.addEventListener('pause', () => {
                    this.isPlaying = false;
                });

                // Double tap to like (mobile)
                let tapCount = 0;
                video.addEventListener('touchend', (e) => {
                    tapCount++;
                    if (tapCount === 1) {
                        setTimeout(() => {
                            if (tapCount === 2) {
                                this.likeVideo(item.dataset.reviewId);
                                this.showLikeAnimation(e.touches ? e.touches[0] : e);
                            }
                            tapCount = 0;
                        }, 300);
                    }
                });
            }
        });
    }

    togglePlayPause() {
        if (this.currentVideo) {
            if (this.isPlaying) {
                this.currentVideo.pause();
                this.isPlaying = false;
                this.showPlayPauseIcon('play');
            } else {
                this.currentVideo.play();
                this.isPlaying = true;
                this.showPlayPauseIcon('pause');
            }
        }
    }

    showPlayPauseIcon(type) {
        const overlay = document.getElementById(`playPause-${this.currentReviewId}`);
        const icon = document.getElementById(`playPauseIcon-${this.currentReviewId}`);
        
        if (overlay && icon) {
            icon.className = `fas fa-${type}`;
            overlay.classList.add('show');
            setTimeout(() => {
                overlay.classList.remove('show');
            }, 500);
        }
    }

    showPlayButton() {
        this.showPlayPauseIcon('play');
    }

    updateProgress() {
        if (this.currentVideo && this.isPlaying) {
            const progress = (this.currentVideo.currentTime / this.currentVideo.duration) * 100;
            const progressBar = document.getElementById(`progress-${this.currentReviewId}`);
            if (progressBar) {
                progressBar.style.width = `${progress}%`;
            }
            
            requestAnimationFrame(() => this.updateProgress());
        }
    }

    showLoading(reviewId) {
        const loading = document.getElementById(`loading-${reviewId}`);
        if (loading) loading.style.display = 'block';
    }

    hideLoading(reviewId) {
        const loading = document.getElementById(`loading-${reviewId}`);
        if (loading) loading.style.display = 'none';
    }

    setupInteractionButtons() {
        // Like buttons
        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const reviewId = btn.dataset.reviewId;
                this.likeVideo(reviewId);
            });
        });

        // Comment buttons
        document.querySelectorAll('.comment-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const reviewId = btn.dataset.reviewId;
                this.showComments(reviewId);
            });
        });

        // Share buttons
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const reviewId = btn.dataset.reviewId;
                this.shareVideo(reviewId);
            });
        });
    }

    async likeVideo(reviewId) {
        try {
            const response = await fetch(`/api/reviews/${reviewId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();
            
            if (data.success) {
                const likeBtn = document.querySelector(`[data-review-id="${reviewId}"].like-btn`);
                const likeCount = likeBtn.parentElement.querySelector('.control-count');
                
                if (data.liked) {
                    likeBtn.classList.add('liked');
                    this.showLikeAnimation();
                } else {
                    likeBtn.classList.remove('liked');
                }
                
                likeCount.textContent = data.likes;
            }
        } catch (error) {
            console.error('Error liking video:', error);
        }
    }

    showLikeAnimation(event) {
        // Create floating heart animation
        const heart = document.createElement('div');
        heart.innerHTML = '❤️';
        heart.style.position = 'absolute';
        heart.style.fontSize = '2rem';
        heart.style.zIndex = '1000';
        heart.style.pointerEvents = 'none';
        heart.style.animation = 'floatUp 1s ease-out forwards';
        
        if (event) {
            heart.style.left = `${event.clientX - 15}px`;
            heart.style.top = `${event.clientY - 15}px`;
        } else {
            heart.style.left = '50%';
            heart.style.top = '50%';
            heart.style.transform = 'translate(-50%, -50%)';
        }
        
        document.body.appendChild(heart);
        
        setTimeout(() => {
            document.body.removeChild(heart);
        }, 1000);
    }

    async showComments(reviewId) {
        this.currentReviewId = reviewId;
        
        try {
            const response = await fetch(`/api/reviews/${reviewId}/comments`);
            const data = await response.json();
            
            this.renderComments(data.comments);
            document.getElementById('commentsPanel').classList.add('show');
        } catch (error) {
            console.error('Error loading comments:', error);
        }
    }

    renderComments(comments) {
        const commentsList = document.getElementById('commentsList');
        commentsList.innerHTML = '';
        
        if (comments.length === 0) {
            commentsList.innerHTML = '<div class="text-center text-muted py-4">No comments yet. Be the first to comment!</div>';
            return;
        }
        
        comments.forEach(comment => {
            const commentElement = document.createElement('div');
            commentElement.className = 'comment-item';
            commentElement.innerHTML = `
                <img src="${comment.user.avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(comment.user.name) + '&background=007bff&color=ffffff&size=32'}" 
                     alt="${comment.user.name}" class="comment-avatar">
                <div class="comment-content">
                    <div class="comment-author">${comment.user.name}</div>
                    <div class="comment-text">${comment.text}</div>
                    <div class="comment-time">${comment.created_at}</div>
                </div>
            `;
            commentsList.appendChild(commentElement);
        });
    }

    async shareVideo(reviewId) {
        const url = `${window.location.origin}/video-reviews?review=${reviewId}`;
        
        if (navigator.share) {
            try {
                await navigator.share({
                    title: 'Check out this product review!',
                    url: url
                });
                
                // Track share
                this.trackShare(reviewId, 'native');
            } catch (error) {
                console.log('Share cancelled');
            }
        } else {
            // Fallback: copy to clipboard
            navigator.clipboard.writeText(url).then(() => {
                alert('Link copied to clipboard!');
                this.trackShare(reviewId, 'copy');
            });
        }
    }

    async trackView(reviewId) {
        try {
            await fetch(`/api/reviews/${reviewId}/view`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
        } catch (error) {
            console.error('Error tracking view:', error);
        }
    }

    async trackShare(reviewId, platform) {
        try {
            await fetch(`/api/reviews/${reviewId}/share`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ platform })
            });
        } catch (error) {
            console.error('Error tracking share:', error);
        }
    }
}

// Global functions for comments
async function postComment() {
    const input = document.getElementById('commentInput');
    const text = input.value.trim();
    
    if (!text || !window.videoPlayer.currentReviewId) return;
    
    try {
        const response = await fetch(`/api/reviews/${window.videoPlayer.currentReviewId}/comments`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ text })
        });
        
        const data = await response.json();
        
        if (data.success) {
            input.value = '';
            // Reload comments
            window.videoPlayer.showComments(window.videoPlayer.currentReviewId);
            
            // Update comment count
            const commentBtn = document.querySelector(`[data-review-id="${window.videoPlayer.currentReviewId}"].comment-btn`);
            const commentCount = commentBtn.parentElement.querySelector('.control-count');
            commentCount.textContent = parseInt(commentCount.textContent) + 1;
        }
    } catch (error) {
        console.error('Error posting comment:', error);
    }
}

function closeComments() {
    document.getElementById('commentsPanel').classList.remove('show');
}

// Add floating heart animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes floatUp {
        0% {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
        100% {
            opacity: 0;
            transform: translateY(-100px) scale(1.5);
        }
    }
`;
document.head.appendChild(style);

// Initialize video player when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Debug: Log video elements and their sources
    console.log('=== Video Debug Info ===');
    const videos = document.querySelectorAll('.video-player');
    console.log(`Found ${videos.length} video elements`);
    
    videos.forEach((video, index) => {
        console.log(`Video ${index + 1}:`);
        console.log('- Element:', video);
        console.log('- Source:', video.querySelector('source')?.src || 'No source');
        console.log('- Ready State:', video.readyState);
        console.log('- Network State:', video.networkState);
        
        // Test if video source is accessible
        if (video.querySelector('source')?.src) {
            fetch(video.querySelector('source').src, { method: 'HEAD' })
                .then(response => {
                    console.log(`- Source accessible: ${response.ok} (${response.status})`);
                })
                .catch(error => {
                    console.log(`- Source error:`, error);
                });
        }
    });
    console.log('=== End Debug Info ===');
    
    window.videoPlayer = new VideoReviewsPlayer();
});

// Handle keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (!window.videoPlayer) return;
    
    switch(e.key) {
        case ' ':
            e.preventDefault();
            window.videoPlayer.togglePlayPause();
            break;
        case 'ArrowUp':
            e.preventDefault();
            // Scroll to previous video
            if (window.videoPlayer.currentIndex > 0) {
                window.videoPlayer.videoFeed.scrollTo({
                    top: (window.videoPlayer.currentIndex - 1) * window.innerHeight,
                    behavior: 'smooth'
                });
            }
            break;
        case 'ArrowDown':
            e.preventDefault();
            // Scroll to next video
            if (window.videoPlayer.currentIndex < window.videoPlayer.videoItems.length - 1) {
                window.videoPlayer.videoFeed.scrollTo({
                    top: (window.videoPlayer.currentIndex + 1) * window.innerHeight,
                    behavior: 'smooth'
                });
            }
            break;
    }
});

// Handle mobile swipe gestures
let startY = 0;
let startTime = 0;

document.addEventListener('touchstart', function(e) {
    startY = e.touches[0].clientY;
    startTime = Date.now();
});

document.addEventListener('touchend', function(e) {
    if (!window.videoPlayer) return;
    
    const endY = e.changedTouches[0].clientY;
    const endTime = Date.now();
    const deltaY = startY - endY;
    const deltaTime = endTime - startTime;
    
    // Swipe detection (minimum distance and maximum time)
    if (Math.abs(deltaY) > 50 && deltaTime < 300) {
        if (deltaY > 0) {
            // Swipe up - next video
            if (window.videoPlayer.currentIndex < window.videoPlayer.videoItems.length - 1) {
                window.videoPlayer.videoFeed.scrollTo({
                    top: (window.videoPlayer.currentIndex + 1) * window.innerHeight,
                    behavior: 'smooth'
                });
            }
        } else {
            // Swipe down - previous video
            if (window.videoPlayer.currentIndex > 0) {
                window.videoPlayer.videoFeed.scrollTo({
                    top: (window.videoPlayer.currentIndex - 1) * window.innerHeight,
                    behavior: 'smooth'
                });
            }
        }
    }
});
</script>
@endpush