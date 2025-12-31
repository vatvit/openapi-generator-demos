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
            \App\Http\Middleware\BearerHttpAuthenticationMiddleware::class,
        ]);

        $middleware->group('api.security.defaultApiKey', [
            \App\Http\Middleware\DefaultApiKeyMiddleware::class,
        ]);

        $middleware->group('api.security.app2AppOauth', [
            \App\Http\Middleware\App2AppOauthMiddleware::class,
        ]);

        $middleware->group('api.security.user2AppOauth', [
            \App\Http\Middleware\User2AppOauthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
