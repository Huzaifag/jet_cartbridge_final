<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Add global middleware for handling large uploads
        $middleware->prepend(\App\Http\Middleware\HandleLargeUploads::class);
        
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'permission' => PermissionMiddleware::class,
            'role_or_permission' => RoleOrPermissionMiddleware::class,
            'unified_dashboard' => \App\Http\Middleware\RedirectToUnifiedDashboard::class,
            'large_uploads' => \App\Http\Middleware\HandleLargeUploads::class,
        ]);
    })
    
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle PostTooLargeException for review uploads
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, $request) {
            if ($request->is('product/*/review') || $request->is('test-upload')) {
                return response()->json([
                    'success' => false,
                    'errors' => ['media.0' => ['File is too large. The total upload size exceeds the server limit. Please try a smaller file or contact support.']]
                ], 413);
            }
        });
    })->create();
