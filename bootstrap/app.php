<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// ✅ Import your custom middlewares
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckAdminRole;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', // optional, add if needed
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {
        /**
         * ----------------------------------------------------------------------
         * Global HTTP Middleware
         * ----------------------------------------------------------------------
         * You can register global middleware here that should run on every
         * request. Example:
         * $middleware->use([...]);
         */

        /**
         * ----------------------------------------------------------------------
         * Route Middleware Aliases
         * ----------------------------------------------------------------------
         * Here we define short aliases for our custom middlewares that can be
         * used directly in routes (e.g., ['auth:admin', 'role:super_admin']).
         */
        $middleware->alias([
            // 🔒 Checks if user is logged in via admin guard
            'admin' => AdminMiddleware::class,

            // 🔐 Role-based access: super_admin / admin
            'role' => CheckAdminRole::class,
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions): void {
        /**
         * ----------------------------------------------------------------------
         * Exception Configuration
         * ----------------------------------------------------------------------
         * You can customize global exception handling here.
         */
        //
    })

    ->create();
