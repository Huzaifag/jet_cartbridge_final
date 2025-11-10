<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register broadcast routes with web middleware
        // Auth will be checked in the channel authorization callbacks
        Broadcast::routes(['middleware' => ['web', 'auth']]);

        require base_path('routes/channels.php');
    }
}
