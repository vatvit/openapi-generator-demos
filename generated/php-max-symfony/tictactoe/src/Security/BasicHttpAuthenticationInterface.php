<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Symfony\Component\HttpFoundation\Request;

/**
 * BasicHttpAuthenticationInterface
 *
 * Security interface for basicHttpAuthentication authentication scheme.
 * Type: http
 *
 * Basic HTTP Authentication
 *
 * Implement this interface in your application to provide authentication logic.
 * Bind your implementation in services.yaml.
 *
 * @generated
 */
interface BasicHttpAuthenticationInterface
{
    /**
     * Validate HTTP Basic authentication credentials.
     *
     * @param string $username The username from Authorization header
     * @param string $password The password from Authorization header
     * @return bool True if credentials are valid
     */
    public function validateCredentials(string $username, string $password): bool;

    /**
     * Get the authenticated user identifier.
     *
     * @param string $username The username from Authorization header
     * @return string|null The user identifier or null if not authenticated
     */
    public function getUserIdentifier(string $username): ?string;

    /**
     * Extract authentication credentials from the request.
     *
     * @param Request $request The incoming HTTP request
     * @return string|null The credentials or null if not present
     */
    public function extractCredentials(Request $request): ?string;
}
