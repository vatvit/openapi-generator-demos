<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TictactoeApi\Api\Security\BearerHttpAuthenticationInterface;

class BearerHttpAuthenticationMiddleware implements BearerHttpAuthenticationInterface
{
    public function handle(Request $request, Closure $next): mixed
    {
        // Stub: Accept all requests for testing
        // In production: validate JWT token from Authorization header
        return $next($request);
    }
}
