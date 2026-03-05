<?php

use App\Http\Middleware\EnsureUserRole;
use App\Http\Middleware\EnsureVerifiedForRole;
use App\Http\Middleware\SecureHeaders;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(SecureHeaders::class);

        $middleware->alias([
            'role' => EnsureUserRole::class,
            'verified.role' => EnsureVerifiedForRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Upload failed. Maximum file size allowed is 5MB.',
                ], 413);
            }

            return back()->with('error', 'Upload failed. Maximum file size allowed is 5MB.');
        });
    })->create();
