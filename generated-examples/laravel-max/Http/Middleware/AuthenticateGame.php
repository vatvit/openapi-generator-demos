<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthenticateGame Middleware
 *
 * Auto-generated from OpenAPI security scheme: bearerHttpAuthentication
 * Validates Bearer token authentication for game operations
 */
class AuthenticateGame
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Missing authentication token'
            ], 401);
        }

        // Validate token (this would connect to your auth system)
        // For example implementation only
        if (!$this->validateToken($token)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Invalid authentication token'
            ], 401);
        }

        return $next($request);
    }

    /**
     * Validate the bearer token
     *
     * Developer implements actual validation logic here
     */
    private function validateToken(string $token): bool
    {
        // TODO: Implement actual token validation
        // Example: return auth()->guard('api')->check();
        return true; // Example only
    }
}
