<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TictactoeApi\Api\Security\User2AppOauthInterface;

class User2AppOauthMiddleware implements User2AppOauthInterface
{
    public function handle(Request $request, Closure $next): mixed
    {
        // Stub: Accept all requests for testing
        // In production: validate OAuth user token
        return $next($request);
    }
}
