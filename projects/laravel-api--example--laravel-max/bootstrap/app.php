<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        apiPrefix: '',  // No prefix - routes match OpenAPI spec exactly
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register security middleware groups for OpenAPI security schemes
        $middleware->group('api.security.bearerHttpAuthentication', [
            LaravelMaxApi\Http\Middleware\AuthenticateGame::class,
        ]);

        // Optional: Operation-specific middleware groups
        // $middleware->group('api.middlewareGroup.createGame', [
        //     // Additional middleware for createGame operation
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
