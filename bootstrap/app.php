<?php

use Illuminate\Foundation\Application; // Import the base Application class for Laravel.
use Illuminate\Foundation\Configuration\Exceptions; // Import the Exceptions configuration class.
use Illuminate\Foundation\Configuration\Middleware; // Import the Middleware configuration class.
use App\Http\Middleware\TrackTraffic; // Import the custom TrackTraffic middleware.

/**
 * Laravel Application Bootstrap File
 *
 * This file is the entry point for configuring and booting up your Laravel application.
 * It's responsible for setting up routing, middleware, exception handling,
 * and creating the core application instance.
 *
 * This specific configuration uses Laravel 10's (or newer) "New Application Structure"
 * which centralizes bootstrap logic.
 */
return Application::configure(basePath: dirname(__DIR__)) // Start configuring the application.
    // `basePath: dirname(__DIR__)` sets the base path of the application
    // to the directory above 'bootstrap' (which is the project root).
    ->withRouting( // Configure how the application loads its routes.
        // Web routes: Defines routes for browser-based access.
        // Loaded from 'routes/web.php'.
        web: __DIR__ . '/../routes/web.php',

        // API routes: Defines routes for API endpoints.
        // Loaded from 'routes/api.php'.
        api: __DIR__ . '/../routes/api.php',

        // Console routes: Defines routes for Artisan commands.
        // Loaded from 'routes/console.php'.
        commands: __DIR__ . '/../routes/console.php',

        // Health check endpoint: A simple route to check application status.
        // Accessible at '/up'.
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) { // Configure application middleware.
        // This closure receives a Middleware configuration object.
        // Middleware are HTTP filters that process requests before they hit controllers
        // and responses before they are sent back to the client.

        // Append the custom `TrackTraffic` middleware to the global middleware stack.
        // This means the `TrackTraffic` middleware will run AFTER Laravel's default
        // global middleware (like EncryptCookies, AddQueuedCookiesToResponse, etc.).
        // By placing it here, it will track *every* incoming web request.
        $middleware->append(TrackTraffic::class);

        $middleware->alias([
            'check.role' => \App\Http\Middleware\CheckRole::class,
            'token.expired' => \App\Http\Middleware\TokenExpired::class, // contoh
            'login.throttle' => \App\Http\Middleware\LoginThrottle::class, // ✅ Tambahkan ini
        ]);

        // --- Important Middleware Context ---
        // You can configure different middleware groups or add more global middleware here.
        // For example, to apply middleware to specific groups:
        /*
        $middleware->web(append: [
            \App\Http\Middleware\VerifyCsrfToken::class,
        ]);

        $middleware->api(prepend: [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
        ]);
        */
        // Or to customize default middleware:
        /*
        $middleware->alias([
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);
        */
    })
    ->withExceptions(function (Exceptions $exceptions) { // Configure application exception handling.
        // This closure receives an Exceptions configuration object.
        // You can customize how exceptions are reported and rendered.
        // Example: Register a custom exception handler for specific exception types.
        /*
        $exceptions->dontReport([
            \Symfony\Component\HttpKernel\Exception\HttpException::class,
        ]);

        $exceptions->renderable(function (\Exception $e, \Illuminate\Http\Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => $e->getMessage()], 500);
            }
        });
        */
    })->create(); // Finalizes the application configuration and creates the Laravel application instance.