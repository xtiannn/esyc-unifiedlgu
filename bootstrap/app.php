<?php

use App\Http\Middleware\CheckPhpAppLogin;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\Role::class,
        ]);
        // Add the custom middleware to the 'web' group
        // $middleware->web(append: [
        //     CheckPhpAppLogin::class,
        // ]);

        // Optionally, alias the middleware for route-specific use
        // $middleware->alias([
        //     'check.php.login' => CheckPhpAppLogin::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
