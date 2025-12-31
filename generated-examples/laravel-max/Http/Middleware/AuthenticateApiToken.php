<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * AuthenticateApiToken
 *
 * EXAMPLE authentication middleware for API endpoints
 * Validates Bearer token from Authorization header
 *
 * This is a SIMPLE EXAMPLE for demonstration purposes.
 * In a real application, you would:
 * - Validate JWT tokens (using firebase/php-jwt or similar)
 * - Verify token signature and expiration
 * - Load user from database
 * - Check user permissions
 *
 * USAGE in bootstrap/app.php:
 * ```php
 * ->withMiddleware(function (Middleware $middleware): void {
 *     // Apply to all operations that require authentication
 *     $middleware->group('api.security.bearerHttpAuthentication', [
 *         \LaravelMaxApi\Http\Middleware\AuthenticateApiToken::class,
 *     ]);
 * })
 * ```
 *
 * GENERATED FROM OPENAPI SECURITY SCHEME:
 * - Scheme: bearerHttpAuthentication
 * - Type: http
 * - Scheme: bearer
 * - Bearer Format: JWT
 */
class AuthenticateApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Extract Authorization header
        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return $this->unauthorized('Missing Authorization header');
        }

        // Validate Bearer token format
        if (!str_starts_with($authHeader, 'Bearer ')) {
            return $this->unauthorized('Invalid Authorization header format. Expected: Bearer {token}');
        }

        // Extract token
        $token = substr($authHeader, 7); // Remove "Bearer " prefix

        if (empty($token)) {
            return $this->unauthorized('Bearer token is empty');
        }

        // EXAMPLE: Simple token validation (NOT for production use)
        // In real app: decode JWT, verify signature, check expiration, load user
        if (!$this->validateToken($token)) {
            return $this->unauthorized('Invalid or expired token');
        }

        // EXAMPLE: Attach user info to request (in real app, load from database)
        $request->attributes->set('user_id', $this->getUserIdFromToken($token));

        return $next($request);
    }

    /**
     * Validate token (EXAMPLE - replace with real JWT validation)
     *
     * @param string $token
     * @return bool
     */
    private function validateToken(string $token): bool
    {
        // EXAMPLE ONLY - accepts any non-empty token
        // In real app:
        // - Decode JWT using firebase/php-jwt
        // - Verify signature with public key
        // - Check expiration (exp claim)
        // - Verify issuer (iss claim)
        // - Check audience (aud claim)

        // For testing: accept "test-token-123" or any token starting with "valid-"
        return $token === 'test-token-123' || str_starts_with($token, 'valid-');
    }

    /**
     * Extract user ID from token (EXAMPLE - replace with real JWT decoding)
     *
     * @param string $token
     * @return string
     */
    private function getUserIdFromToken(string $token): string
    {
        // EXAMPLE ONLY - returns dummy user ID
        // In real app:
        // - Decode JWT payload
        // - Extract user ID from 'sub' claim or custom claim
        // - Load user from database
        // - Attach full user object to request

        if ($token === 'test-token-123') {
            return 'test-user-id';
        }

        return 'user-' . substr(md5($token), 0, 8);
    }

    /**
     * Return unauthorized response (401)
     *
     * Matches OpenAPI UnauthorizedError schema
     *
     * @param string $message
     * @return Response
     */
    private function unauthorized(string $message): Response
    {
        return response()->json([
            'error' => 'Unauthorized',
            'message' => $message,
            'code' => 'UNAUTHORIZED',
        ], 401);
    }
}
