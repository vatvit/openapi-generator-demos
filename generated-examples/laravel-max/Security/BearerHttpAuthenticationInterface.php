<?php

declare(strict_types=1);

namespace LaravelMaxApi\Security;

use Closure;
use Illuminate\Http\Request;

/**
 * BearerHttpAuthenticationInterface
 *
 * Auto-generated security interface from OpenAPI security scheme: bearerHttpAuthentication
 *
 * DEVELOPER MUST implement this interface in their authentication middleware
 * The library validates that middleware implementing this interface is attached to protected routes
 *
 * OpenAPI Security Scheme:
 * - Type: http
 * - Scheme: bearer
 * - Bearer Format: JWT
 *
 * PSR-4 COMPLIANT: One interface per security scheme
 */
interface BearerHttpAuthenticationInterface
{
    /**
     * Handle an incoming request
     *
     * This method MUST:
     * - Extract Bearer token from request
     * - Validate the token (JWT signature, expiration, etc.)
     * - Return 401 response if authentication fails
     * - Call $next($request) if authentication succeeds
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next);
}
