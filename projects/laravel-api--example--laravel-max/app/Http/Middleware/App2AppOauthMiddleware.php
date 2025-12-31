<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TictactoeApi\Api\Security\App2AppOauthInterface;

class App2AppOauthMiddleware implements App2AppOauthInterface
{
    public function handle(Request $request, Closure $next): mixed
    {
        // Stub: Accept all requests for testing
        // In production: validate OAuth client credentials
        return $next($request);
    }
}
