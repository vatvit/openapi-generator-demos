<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use TictactoeApi\Api\Security\DefaultApiKeyInterface;

class DefaultApiKeyMiddleware implements DefaultApiKeyInterface
{
    public function handle(Request $request, Closure $next): mixed
    {
        // Stub: Accept all requests for testing
        // In production: validate API key from header/query
        return $next($request);
    }
}
