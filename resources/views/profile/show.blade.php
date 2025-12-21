@extends('frontend.layout.main')

@push('styles')
<style>
/* LinkedIn-style Profile Styles */
.linkedin-profile {
    background: #f3f2ef;
    min-height: 100vh;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
}

.profile-header-card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
    margin-bottom: 8px;
    overflow: hidden;
    position: relative;
}

.cover-photo {
    height: 200px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    background-size: cover;
    background-position: center;
    position: relative;
}

.profile-main-info {
    padding: 24px 24px 16px;
    position: relative;
}

.profile-avatar {
    position: absolute;
    top: -80px;
    left: 24px;
    width: 152px;
    height: 152px;
    border: 4px solid white;
    border-radius: 50%;
    overflow: hidden;
    background: white;
    box-shadow: 0 4px 8px rgba(0,0,0,.12);
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.verified-badge {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: #0a66c2;
    color: white;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
}

.profile-content-area {
    margin-left: 176px;
    margin-top: 16px;
}

.profile-name {
    font-size: 32px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0 0 4px 0;
    line-height: 1.25;
}

.profile-headline {
    font-size: 20px;
    font-weight: 400;
    color: rgba(0,0,0,.9);
    margin: 0 0 8px 0;
    line-height: 1.25;
}

.profile-location {
    color: rgba(0,0,0,.6);
    font-size: 14px;
    margin: 0 0 12px 0;
}

.profile-stats {
    display: flex;
    gap: 16px;
    margin: 12px 0;
}

.stat-link {
    color: #0a66c2;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
}

.stat-link:hover {
    text-decoration: underline;
    color: #004182;
}

.profile-actions {
    position: absolute;
    top: 16px;
    right: 24px;
    display: flex;
    gap: 8px;
}

.btn-linkedin-primary {
    background: #0a66c2;
    color: white;
    border: 1px solid #0a66c2;
    border-radius: 24px;
    padding: 6px 16px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.2s;
}

.btn-linkedin-primary:hover {
    background: #004182;
    border-color: #004182;
    color: white;
}

.btn-linkedin-secondary {
    background: transparent;
    color: #0a66c2;
    border: 1px solid #0a66c2;
    border-radius: 24px;
    padding: 6px 16px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.2s;
}

.btn-linkedin-secondary:hover {
    background: rgba(112, 181, 249, 0.2);
    color: #0a66c2;
}

.profile-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
    margin-bottom: 8px;
    padding: 24px;
}

.section-header {
    display: flex;
    align-items: center;
    justify-content: between;
    margin-bottom: 16px;
}

.section-title {
    font-size: 20px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0;
}

.experience-item, .education-item, .certification-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0,0,0,.08);
}

.experience-item:last-child, .education-item:last-child, .certification-item:last-child {
    border-bottom: none;
}

.item-logo {
    width: 48px;
    height: 48px;
    border-radius: 4px;
    overflow: hidden;
    flex-shrink: 0;
    background: #f3f2ef;
    display: flex;
    align-items: center;
    justify-content: center;
}

.item-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.item-details {
    flex: 1;
}

.item-title {
    font-size: 16px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0 0 2px 0;
}

.item-subtitle {
    font-size: 14px;
    color: rgba(0,0,0,.6);
    margin: 0 0 4px 0;
}

.item-duration {
    font-size: 14px;
    color: rgba(0,0,0,.6);
    margin: 0 0 8px 0;
}

.item-description {
    font-size: 14px;
    color: rgba(0,0,0,.9);
    line-height: 1.4;
    margin: 8px 0 0 0;
}

.skills-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 12px;
}

.skill-tag {
    background: rgba(0,0,0,.08);
    color: rgba(0,0,0,.9);
    padding: 4px 8px;
    border-radius: 16px;
    font-size: 12px;
    font-weight: 600;
}

.sidebar-section {
    background: white;
    border-radius: 8px;
    box-shadow: 0 0 0 1px rgba(0,0,0,.15), 0 2px 3px rgba(0,0,0,.2);
    margin-bottom: 8px;
    padding: 16px;
}

.sidebar-title {
    font-size: 16px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0 0 12px 0;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
    font-size: 14px;
    color: rgba(0,0,0,.6);
}

.contact-item i {
    width: 16px;
    color: rgba(0,0,0,.6);
}

.contact-item a {
    color: #0a66c2;
    text-decoration: none;
}

.contact-item a:hover {
    text-decoration: underline;
}

.connections-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
    margin-top: 12px;
}

.connection-item {
    text-align: center;
    text-decoration: none;
    color: inherit;
}

.connection-avatar {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 4px;
    border: 2px solid transparent;
    transition: border-color 0.2s;
}

.connection-item:hover .connection-avatar {
    border-color: #0a66c2;
}

.connection-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.connection-name {
    font-size: 12px;
    color: rgba(0,0,0,.9);
    font-weight: 600;
    margin: 0;
    line-height: 1.2;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 16px;
    margin-top: 16px;
}

.activity-item {
    display: flex;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid rgba(0,0,0,.08);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(0,0,0,.08);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.activity-content {
    flex: 1;
}

.activity-title {
    font-size: 14px;
    font-weight: 600;
    color: rgba(0,0,0,.9);
    margin: 0 0 4px 0;
}

.activity-description {
    font-size: 14px;
    color: rgba(0,0,0,.6);
    margin: 0 0 4px 0;
    line-height: 1.4;
}

.activity-time {
    font-size: 12px;
    color: rgba(0,0,0,.6);
}

@media (max-width: 768px) {
    .profile-content-area {
        margin-left: 0;
        margin-top: 80px;
    }
    
    .profile-avatar {
        position: relative;
        top: -60px;
        left: 50%;
        transform: translateX(-50%);
        width: 120px;
        height: 120px;
    }
    
    .profile-main-info {
        text-align: center;
        padding-top: 0;
    }
    
    .profile-actions {
        position: static;
        justify-content: center;
        margin-top: 16px;
    }
}
</style>
@endpush

@section('content')
<div class="linkedin-profile">
    <div class="container-fluid" style="max-width: 1128px;">
        <div class="row">
            <div class="col-lg-8">
                <!-- Profile Header Card -->
                <div class="profile-header-card">
                    <div class="cover-photo" style="background-image: url('{{ $user->profile?->cover_photo_url ?? asset('images/default-cover.jpg') }}');"></div>
                    
                    <div class="profile-main-info">
                        <div class="profile-avatar">
                            <img src="{{ $user->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=0a66c2&color=ffffff&size=152' }}" alt="{{ $user->name }}">
                            @if($user->profile?->identity_verified)
                                <div class="verified-badge">
                                    <i class="fas fa-check"></i>
                                </div>
                            @endif
                        </div>
                        
                        <div class="profile-content-area">
                            <h1 class="profile-name">{{ $user->profile?->first_name && $user->profile?->last_name ? $user->profile->first_name . ' ' . $user->profile->last_name : $user->name }}</h1>
                            
                            @if($user->profile?->job_title || $user->profile?->company)
                                <div class="profile-headline">
                                    @if($user->profile?->job_title)
                                        {{ $user->profile->job_title }}
                                    @endif
                                    @if($user->profile?->job_title && $user->profile?->company)
                                        at {{ $user->profile->company }}
                                    @elseif($user->profile?->company)
                                        {{ $user->profile->company }}
                                    @endif
                                </div>
                            @endif
                            
                           @php
    $profile = $user->profile;
@endphp

@if($profile && ($profile->city || $profile->state || $profile->country))
    <div class="profile-location">
        <i class="fas fa-map-marker-alt me-1"></i>

        @if($profile->city)
            {{ $profile->city }}
        @endif

        @if($profile->city && ($profile->state || $profile->country))
            , 
        @endif

        @if($profile->state)
            {{ $profile->state }}
        @endif

        @if($profile->state && $profile->country)
            , 
        @endif

        @if($profile->country)
            {{ $profile->country }}
        @endif
    </div>
@endif

                            
                            <div class="profile-stats">
                                @if($user->profile?->connection_count > 0)
                                    <a href="{{ route('profile.connections') }}" class="stat-link">
                                        {{ $user->profile->connection_count }} connection{{ $user->profile->connection_count != 1 ? 's' : '' }}
                                    </a>
                                @endif
                                @if($user->profile?->profile_views > 0)
                                    <span class="stat-link" style="color: rgba(0,0,0,.6); cursor: default;">
                                        {{ number_format($user->profile->profile_views) }} profile view{{ $user->profile->profile_views != 1 ? 's' : '' }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="profile-actions">
                            @if($isOwnProfile)
                                <a href="{{ route('profile.edit') }}" class="btn btn-linkedin-secondary">
                                    <i class="fas fa-pencil-alt me-1"></i> Edit profile
                                </a>
                            @else
                                @if($connectionStatus === 'none')
                                    <button class="btn btn-linkedin-primary" data-bs-toggle="modal" data-bs-target="#connectModal">
                                        <i class="fas fa-user-plus me-1"></i> Connect
                                    </button>
                                @elseif($connectionStatus === 'pending')
                                    <button class="btn btn-linkedin-secondary" disabled>
                                        <i class="fas fa-clock me-1"></i> Pending
                                    </button>
                                @elseif($connectionStatus === 'accepted')
                                    <button class="btn btn-linkedin-secondary" disabled>
                                        <i class="fas fa-check me-1"></i> Connected
                                    </button>
                                @endif
                                
                                <button class="btn btn-linkedin-secondary">
                                    <i class="fas fa-envelope me-1"></i> Message
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- About Section -->
                @if($user->profile?->bio || $user->profile?->professional_summary)
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">About</h2>
                        </div>
                        <div class="section-content">
                            @if($user->profile->professional_summary)
                                <p class="item-description">{{ $user->profile->professional_summary }}</p>
                            @endif
                            @if($user->profile->bio && $user->profile->professional_summary)
                                <br>
                            @endif
                            @if($user->profile->bio)
                                <p class="item-description">{{ $user->profile->bio }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Experience Section -->
                @if($user->workExperiences && $user->workExperiences->count() > 0)
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">Experience</h2>
                        </div>
                        <div class="section-content">
                            @foreach($user->workExperiences as $experience)
                                <div class="experience-item">
                                    <div class="item-logo">
                                        <img src="{{ $experience->company_logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($experience->company_name) . '&background=f3f2ef&color=666666&size=48' }}" alt="{{ $experience->company_name }}">
                                    </div>
                                    <div class="item-details">
                                        <h3 class="item-title">{{ $experience->job_title }}</h3>
                                        <div class="item-subtitle">
                                            {{ $experience->company_name }}
                                            @if($experience->employment_type)
                                                · {{ $experience->employment_type }}
                                            @endif
                                        </div>
                                        <div class="item-duration">{{ $experience->formatted_duration ?? $experience->start_date->format('M Y') . ' - ' . ($experience->is_current ? 'Present' : $experience->end_date->format('M Y')) }}</div>
                                        @if($experience->location)
                                            <div class="item-subtitle">
                                                <i class="fas fa-map-marker-alt me-1"></i>
                                                {{ $experience->location }}
                                                @if($experience->is_remote) · Remote @endif
                                            </div>
                                        @endif
                                        @if($experience->description)
                                            <div class="item-description">{{ $experience->description }}</div>
                                        @endif
                                        @if($experience->skills_used && count($experience->skills_used) > 0)
                                            <div class="skills-container">
                                                <strong style="font-size: 14px; color: rgba(0,0,0,.6); margin-right: 8px;">Skills:</strong>
                                                @foreach($experience->skills_used as $skill)
                                                    <span class="skill-tag">{{ $skill }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Education Section -->
                @if($user->educations && $user->educations->count() > 0)
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">Education</h2>
                        </div>
                        <div class="section-content">
                            @foreach($user->educations as $education)
                                <div class="education-item">
                                    <div class="item-logo">
                                        <img src="{{ $education->institution_logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($education->institution_name) . '&background=f3f2ef&color=666666&size=48' }}" alt="{{ $education->institution_name }}">
                                    </div>
                                    <div class="item-details">
                                        <h3 class="item-title">{{ $education->institution_name }}</h3>
                                        @if($education->degree || $education->field_of_study)
                                            <div class="item-subtitle">
                                                @if($education->degree){{ $education->degree }}@endif
                                                @if($education->degree && $education->field_of_study), @endif
                                                @if($education->field_of_study){{ $education->field_of_study }}@endif
                                            </div>
                                        @endif
                                        <div class="item-duration">{{ $education->duration ?? $education->start_date->format('Y') . ' - ' . ($education->is_current ? 'Present' : $education->end_date->format('Y')) }}</div>
                                        @if($education->formatted_grade)
                                            <div class="item-subtitle">Grade: {{ $education->formatted_grade }}</div>
                                        @endif
                                        @if($education->description)
                                            <div class="item-description">{{ $education->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Certifications Section -->
                @if($user->certifications && $user->certifications->count() > 0)
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">Licenses & certifications</h2>
                        </div>
                        <div class="section-content">
                            @foreach($user->certifications as $certification)
                                <div class="certification-item">
                                    <div class="item-logo">
                                        <img src="{{ $certification->organization_logo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($certification->issuing_organization) . '&background=f3f2ef&color=666666&size=48' }}" alt="{{ $certification->issuing_organization }}">
                                    </div>
                                    <div class="item-details">
                                        <h3 class="item-title">{{ $certification->name }}</h3>
                                        <div class="item-subtitle">{{ $certification->issuing_organization }}</div>
                                        <div class="item-duration">{{ $certification->formatted_duration ?? 'Issued ' . $certification->issue_date->format('M Y') . ($certification->does_not_expire ? ' · No Expiration Date' : ($certification->expiration_date ? ' · Expires ' . $certification->expiration_date->format('M Y') : '')) }}</div>
                                        @if($certification->credential_id)
                                            <div class="item-subtitle">Credential ID: {{ $certification->credential_id }}</div>
                                        @endif
                                        @if($certification->credential_url)
                                            <div style="margin-top: 8px;">
                                                <a href="{{ $certification->credential_url }}" target="_blank" class="stat-link">
                                                    <i class="fas fa-external-link-alt me-1"></i>Show credential
                                                </a>
                                            </div>
                                        @endif
                                        @if($certification->description)
                                            <div class="item-description">{{ $certification->description }}</div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Skills Section -->
                @if($user->profile?->skills && count($user->profile->skills) > 0)
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">Skills</h2>
                        </div>
                        <div class="section-content">
                            <div class="skills-container">
                                @foreach($user->profile->skills as $skill)
                                    <span class="skill-tag">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Activity Section -->
                @if(isset($recentActivity) && $recentActivity->count() > 0)
                    <div class="profile-section">
                        <div class="section-header">
                            <h2 class="section-title">Activity</h2>
                        </div>
                        <div class="section-content">
                            @foreach($recentActivity as $activity)
                                <div class="activity-item">
                                    <div class="activity-icon">
                                        <i class="fas fa-{{ $activity['type'] === 'review' ? 'star' : 'box' }}"></i>
                                    </div>
                                    <div class="activity-content">
                                        <div class="activity-title">
                                            <a href="{{ $activity['url'] }}" style="color: rgba(0,0,0,.9); text-decoration: none;">{{ $activity['title'] }}</a>
                                        </div>
                                        <div class="activity-description">{{ $activity['description'] }}</div>
                                        <div class="activity-time">{{ $activity['date']->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Contact Info -->
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Contact info</h3>
                    <div class="contact-info">
                        @if(($user->profile?->show_email ?? true) || $isOwnProfile)
                            <div class="contact-item">
                                <i class="fas fa-envelope"></i>
                                <span>{{ $user->email }}</span>
                            </div>
                        @endif
                        @if(($user->profile?->phone && ($user->profile?->show_phone ?? false)) || $isOwnProfile)
                            <div class="contact-item">
                                <i class="fas fa-phone"></i>
                                <span>{{ $user->profile?->phone }}</span>
                            </div>
                        @endif
                        @if($user->profile?->website)
                            <div class="contact-item">
                                <i class="fas fa-globe"></i>
                                <a href="{{ $user->profile->website }}" target="_blank">Website</a>
                            </div>
                        @endif
                        @if($user->profile?->linkedin_url)
                            <div class="contact-item">
                                <i class="fab fa-linkedin"></i>
                                <a href="{{ $user->profile->linkedin_url }}" target="_blank">LinkedIn</a>
                            </div>
                        @endif
                        @if($user->profile?->social_links && count($user->profile->social_links) > 0)
                            @foreach($user->profile->social_links as $social)
                                <div class="contact-item">
                                    <i class="fab fa-{{ strtolower($social['platform']) }}"></i>
                                    <a href="{{ $social['url'] }}" target="_blank">{{ $social['platform'] }}</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <!-- Connections -->
                @if(isset($user->connections) && $user->connections->count() > 0)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">
                            {{ $user->profile?->connection_count ?? $user->connections->count() }} connections
                        </h3>
                        <div class="connections-grid">
                            @foreach($user->connections->take(6) as $connection)
                                <a href="{{ route('user.profile.public', $connection->connectedUser) }}" class="connection-item">
                                    <div class="connection-avatar">
                                        <img src="{{ $connection->connectedUser->profile_picture_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($connection->connectedUser->name) . '&background=0a66c2&color=ffffff&size=56' }}" alt="{{ $connection->connectedUser->name }}">
                                    </div>
                                    <div class="connection-name">{{ $connection->connectedUser->name }}</div>
                                </a>
                            @endforeach
                        </div>
                        @if(($user->profile?->connection_count ?? $user->connections->count()) > 6)
                            <div class="text-center mt-3">
                                <a href="{{ route('profile.connections') }}" class="btn btn-linkedin-secondary btn-sm" style="width: 100%;">
                                    View all connections
                                </a>
                            </div>
                        @endif
                    </div>
                @endif

                


                <!-- Posted Products (Sidebar) -->
                @if(isset($postedProducts) && $postedProducts->count() > 0)
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Products ({{ $postedProducts->count() }})</h3>
                        <div class="products-grid">
                            @foreach($postedProducts->take(4) as $product)
                            @php
                                $stock = $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock';
                                $images = is_array($product->images)
                                    ? $product->images
                                    : json_decode($product->images, true);
                                $firstImage = str_replace('\/', '/', $images[0] ?? 'default.png');
                                $showTrendingBadge = $showTrendingBadge ?? false;
                            @endphp
                                <div class="product-preview">
                                    <a href="{{ route('product.show', $product->slug) }}" style="text-decoration: none; color: inherit;">
                                        <img src="{{$firstImage}}" alt="{{ $product->name }}" style="width: 100%; height: 120px; object-fit: cover; border-radius: 4px; margin-bottom: 8px;">
                                        <div style="font-size: 14px; font-weight: 600; color: rgba(0,0,0,.9); line-height: 1.2;">{{ Str::limit($product->name, 40) }}</div>
                                        <div style="font-size: 12px; color: rgba(0,0,0,.6); margin-top: 4px;">{{ $product->formatted_price }}</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        @if($postedProducts->count() > 4)
                            <div class="text-center mt-3">
                                <a href="{{ route('seller.profile', $user->seller->slug ?? '#') }}" class="btn btn-linkedin-secondary btn-sm" style="width: 100%;">
                                    View all products
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Connect Modal -->
@if(!$isOwnProfile && $connectionStatus === 'none')
    <div class="modal fade" id="connectModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 8px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,.15);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(0,0,0,.08); padding: 20px 24px;">
                    <h5 class="modal-title" style="font-weight: 600; color: rgba(0,0,0,.9);">
                        Invite {{ $user->profile?->first_name ?? $user->name }} to connect
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" style="margin: 0;"></button>
                </div>
                <form action="{{ route('profile.connect', $user) }}" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 20px 24px;">
                        <div class="mb-3">
                            <label for="connection_type" class="form-label" style="font-weight: 600; color: rgba(0,0,0,.9); margin-bottom: 8px;">
                                How do you know {{ $user->profile?->first_name ?? $user->name }}?
                            </label>
                            <select name="connection_type" id="connection_type" class="form-select" style="border: 1px solid rgba(0,0,0,.3); border-radius: 4px; padding: 8px 12px;">
                                <option value="">Select relationship</option>
                                <option value="colleague">Colleague</option>
                                <option value="client">Client</option>
                                <option value="supplier">Supplier</option>
                                <option value="partner">Business Partner</option>
                                <option value="friend">Friend</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label" style="font-weight: 600; color: rgba(0,0,0,.9); margin-bottom: 8px;">
                                Add a personal note
                            </label>
                            <textarea name="message" id="message" class="form-control" rows="3" 
                                style="border: 1px solid rgba(0,0,0,.3); border-radius: 4px; padding: 8px 12px; resize: vertical;"
                                placeholder="Hi {{ $user->profile?->first_name ?? $user->name }}, I'd like to connect with you on our platform."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(0,0,0,.08); padding: 16px 24px; justify-content: flex-end;">
                        <button type="button" class="btn btn-linkedin-secondary me-2" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-linkedin-primary">Send invitation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
@endsection