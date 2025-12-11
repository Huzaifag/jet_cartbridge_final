<!-- Default Dashboard Content -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-body text-center py-5">
                <i class="fas fa-tachometer-alt fa-4x text-muted mb-4"></i>
                <h3>Welcome to Your Dashboard</h3>
                <p class="text-muted mb-4">
                    {{ $message ?? 'Your personalized dashboard will appear here based on your role and permissions.' }}
                </p>
                
                @if(auth()->user()->role)
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        You are logged in as: <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                    </div>
                @endif

                <div class="row mt-4">
                    <div class="col-md-4 mb-3">
                        <div class="card border-primary">
                            <div class="card-body">
                                <i class="fas fa-user-circle fa-2x text-primary mb-2"></i>
                                <h6>Profile</h6>
                                <p class="small text-muted">Manage your account settings</p>
                                <a href="{{ route('user.profile') }}" class="btn btn-outline-primary btn-sm">
                                    View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <i class="fas fa-envelope fa-2x text-success mb-2"></i>
                                <h6>Messages</h6>
                                <p class="small text-muted">Check your messages</p>
                                <button class="btn btn-outline-success btn-sm">
                                    View Messages
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <div class="card border-info">
                            <div class="card-body">
                                <i class="fas fa-cog fa-2x text-info mb-2"></i>
                                <h6>Settings</h6>
                                <p class="small text-muted">Configure your preferences</p>
                                <button class="btn btn-outline-info btn-sm">
                                    Settings
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>