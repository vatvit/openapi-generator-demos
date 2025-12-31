<?php declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Closure;
use Illuminate\Http\Request;

/**
 * BasicHttpAuthenticationInterface
 *
 * Auto-generated security interface from OpenAPI security scheme: basicHttpAuthentication
 *
 * DEVELOPER MUST implement this interface in their authentication middleware
 * The library validates that middleware implementing this interface is attached to protected routes
 *
 * OpenAPI Security Scheme:
 * - Type: http
 * - Description: Basic HTTP Authentication
 * - Scheme: Basic
 *
 * PSR-4 COMPLIANT: One interface per security scheme
 */
interface BasicHttpAuthenticationInterface
{
    /**
     * Handle an incoming request
     *
     * This method MUST:
     * - Extract Basic auth credentials from Authorization header
     * - Validate username and password
     * - Return 401 response if authentication fails
     * - Call $next($request) if authentication succeeds
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next);
}
