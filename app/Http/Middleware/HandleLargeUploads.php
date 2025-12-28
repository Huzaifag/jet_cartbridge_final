<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            // Log current settings before changes
            Log::info('Upload middleware applied', [
                'route' => $request->path(),
                'before_upload_max_filesize' => ini_get('upload_max_filesize'),
                'before_post_max_size' => ini_get('post_max_size'),
                'before_max_execution_time' => ini_get('max_execution_time'),
                'before_memory_limit' => ini_get('memory_limit'),
            ]);
            
            // Increase PHP limits for large uploads
            ini_set('upload_max_filesize', '100M');
            ini_set('post_max_size', '110M');
            ini_set('max_execution_time', '300');
            ini_set('max_input_time', '300');
            ini_set('memory_limit', '256M');
            
            // Log settings after changes
            Log::info('Upload limits increased', [
                'after_upload_max_filesize' => ini_get('upload_max_filesize'),
                'after_post_max_size' => ini_get('post_max_size'),
                'after_max_execution_time' => ini_get('max_execution_time'),
                'after_memory_limit' => ini_get('memory_limit'),
            ]);
            
            // Override Laravel's post size validation for these routes
            $request->server->set('CONTENT_LENGTH', min($request->server->get('CONTENT_LENGTH', 0), 110 * 1024 * 1024));
        }
        
        return $next($request);
    }
}