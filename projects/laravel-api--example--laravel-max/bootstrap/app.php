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
        // This middleware group corresponds to the "bearerHttpAuthentication" security scheme in OpenAPI spec
        $middleware->group('api.security.bearerHttpAuthentication', [
            LaravelMaxApi\Http\Middleware\AuthenticateApiToken::class,
        ]);

        // Optional: Operation-specific middleware groups
        // You can define additional middleware for specific operations
        // $middleware->group('api.middlewareGroup.createGame', [
        //     // Additional middleware only for createGame operation
        //     // e.g., rate limiting, logging, etc.
        // ]);
        //
        // $middleware->group('api.middlewareGroup.deleteGame', [
        //     \App\Http\Middleware\CheckGameOwnership::class,
        // ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
