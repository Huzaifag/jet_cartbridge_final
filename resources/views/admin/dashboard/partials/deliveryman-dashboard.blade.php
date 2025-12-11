<!-- Deliveryman Dashboard Content -->
<div class="row mb-4">
    <!-- Stats Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Pending Deliveries
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $pending_deliveries ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-truck fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Completed Deliveries
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $completed_deliveries ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Today's Routes
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            0
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-route fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Delivery Rate
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            @php
                                $total = ($pending_deliveries ?? 0) + ($completed_deliveries ?? 0);
                                $rate = $total > 0 ? round((($completed_deliveries ?? 0) / $total) * 100, 1) : 0;
                            @endphp
                            {{ $rate }}%
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-percentage fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delivery Operations -->
<div class="row">
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Delivery Routes</h6>
            </div>
            <div class="card-body">
                <div class="text-center py-4">
                    <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                    <h5>Route Planning</h5>
                    <p class="text-muted">Optimize your delivery routes and track delivery progress.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Today's Schedule</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <p class="text-muted">Your delivery schedule will appear here</p>
                    <button class="btn btn-primary btn-sm">
                        View All Deliveries
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>