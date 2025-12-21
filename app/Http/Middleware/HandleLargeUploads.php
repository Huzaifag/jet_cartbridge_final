<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleLargeUploads
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply to review upload routes
        if ($request->is('product/*/review') || $request->is('test-upload')) {
            // Increase PHP limits for large uploads
            ini_set('upload_max_filesize', '100M');
            ini_set('post_max_size', '110M');
            ini_set('max_execution_time', '300');
            ini_set('max_input_time', '300');
            ini_set('memory_limit', '256M');
            
            // Override Laravel's post size validation for these routes
            $request->server->set('CONTENT_LENGTH', min($request->server->get('CONTENT_LENGTH', 0), 110 * 1024 * 1024));
        }
        
        return $next($request);
    }
}