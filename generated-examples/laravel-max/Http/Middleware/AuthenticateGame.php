<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Middleware;

use LaravelMaxApi\Security\BearerHttpAuthenticationInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthenticateGame Middleware
 *
 * EXAMPLE implementation of Bearer token authentication
 * Auto-generated from OpenAPI security scheme: bearerHttpAuthentication
 *
 * IMPLEMENTS: BearerHttpAuthenticationInterface (REQUIRED)
 * This ensures the middleware fulfills the contract from OpenAPI spec
 * The library validates this interface is implemented in debug mode
 *
 * In a real application, this would:
 * - Validate JWT token signature
 * - Check token expiration
 * - Load user from token claims
 * - Store authenticated user in request
 *
 * PSR-4 COMPLIANT: One class per file
 */
class AuthenticateGame implements BearerHttpAuthenticationInterface
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
