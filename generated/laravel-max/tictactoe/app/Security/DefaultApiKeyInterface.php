<?php declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Closure;
use Illuminate\Http\Request;

/**
 * DefaultApiKeyInterface
 *
 * Auto-generated security interface from OpenAPI security scheme: defaultApiKey
 *
 * DEVELOPER MUST implement this interface in their authentication middleware
 * The library validates that middleware implementing this interface is attached to protected routes
 *
 * OpenAPI Security Scheme:
 * - Type: apiKey
 * - Description: API key provided in console
 * - In: header
 * - Name: api-key
 *
 * PSR-4 COMPLIANT: One interface per security scheme
 */
interface DefaultApiKeyInterface
{
    /**
     * Handle an incoming request
     *
     * This method MUST:
     * - Extract API key from header: api-key
     * - Validate the API key
     * - Return 401 response if authentication fails
     * - Call $next($request) if authentication succeeds
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next);
}
