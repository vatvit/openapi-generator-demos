<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Symfony\Component\HttpFoundation\Request;

/**
 * User2AppOauthInterface
 *
 * Security interface for user2AppOauth authentication scheme.
 * Type: oauth2
 *
 * Implement this interface in your application to provide authentication logic.
 * Bind your implementation in services.yaml.
 *
 * @generated
 */
interface User2AppOauthInterface
{
    /**
     * Validate OAuth2 access token.
     *
     * Flows: authorizationCode
     *
     * @param string $accessToken The OAuth2 access token
     * @param array<string> $requiredScopes The scopes required for this operation
     * @return bool True if token is valid and has required scopes
     */
    public function validateToken(string $accessToken, array $requiredScopes = []): bool;

    /**
     * Get the authenticated user identifier from access token.
     *
     * @param string $accessToken The OAuth2 access token
     * @return string|null The user identifier or null if not authenticated
     */
    public function getUserIdentifier(string $accessToken): ?string;

    /**
     * Get the scopes associated with the access token.
     *
     * @param string $accessToken The OAuth2 access token
     * @return array<string> The scopes
     */
    public function getTokenScopes(string $accessToken): array;

    /**
     * Extract authentication credentials from the request.
     *
     * @param Request $request The incoming HTTP request
     * @return string|null The credentials or null if not present
     */
    public function extractCredentials(Request $request): ?string;
}
