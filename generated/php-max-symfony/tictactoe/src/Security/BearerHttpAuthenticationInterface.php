<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Symfony\Component\HttpFoundation\Request;

/**
 * BearerHttpAuthenticationInterface
 *
 * Security interface for bearerHttpAuthentication authentication scheme.
 * Type: http
 *
 * Bearer token using a JWT
 *
 * Implement this interface in your application to provide authentication logic.
 * Bind your implementation in services.yaml.
 *
 * @generated
 */
interface BearerHttpAuthenticationInterface
{
    /**
     * Validate Bearer token.
     *
     * @param string $token The Bearer token from Authorization header
     * @return bool True if token is valid
     */
    public function validateToken(string $token): bool;

    /**
     * Get the authenticated user identifier from token.
     *
     * @param string $token The Bearer token
     * @return string|null The user identifier or null if not authenticated
     */
    public function getUserIdentifier(string $token): ?string;

    /**
     * Extract authentication credentials from the request.
     *
     * @param Request $request The incoming HTTP request
     * @return string|null The credentials or null if not present
     */
    public function extractCredentials(Request $request): ?string;
}
