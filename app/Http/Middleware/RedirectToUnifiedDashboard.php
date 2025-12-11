<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectToUnifiedDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // If user is authenticated and trying to access old dashboard routes
        if (Auth::check()) {
            $currentRoute = $request->route()->getName();
            
            // List of old dashboard routes to redirect
            $oldDashboardRoutes = [
                'seller.dashboard',
                'manufacturer.dashboard',
                'accountant.dashboard',
                // Add other role-specific dashboard routes here
            ];
            
            if (in_array($currentRoute, $oldDashboardRoutes)) {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}