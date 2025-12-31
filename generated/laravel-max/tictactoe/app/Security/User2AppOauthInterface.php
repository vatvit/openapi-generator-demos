<?php declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Closure;
use Illuminate\Http\Request;

/**
 * User2AppOauthInterface
 *
 * Auto-generated security interface from OpenAPI security scheme: user2AppOauth
 *
 * DEVELOPER MUST implement this interface in their authentication middleware
 * The library validates that middleware implementing this interface is attached to protected routes
 *
 * OpenAPI Security Scheme:
 * - Type: oauth2
 * - OAuth2 Flow (see OpenAPI spec for details)
 *
 * PSR-4 COMPLIANT: One interface per security scheme
 */
interface User2AppOauthInterface
{
    /**
     * Handle an incoming request
     *
     * This method MUST:
     * - Extract OAuth2 access token from Authorization header
     * - Validate the token and required scopes
     * - Return 401 response if authentication fails
     * - Call $next($request) if authentication succeeds
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next);
}
