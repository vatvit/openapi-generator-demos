<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Security;

use Symfony\Component\HttpFoundation\Request;

/**
 * DefaultApiKeyInterface
 *
 * Security interface for defaultApiKey authentication scheme.
 * Type: apiKey
 *
 * API key provided in console
 *
 * Implement this interface in your application to provide authentication logic.
 * Bind your implementation in services.yaml.
 *
 * @generated
 */
interface DefaultApiKeyInterface
{
    /**
     * Validate API key.
     *
     * API Key Name: api-key
     * API Key Location: header
     *
     * @param string $apiKey The API key value
     * @return bool True if API key is valid
     */
    public function validateApiKey(string $apiKey): bool;

    /**
     * Get the authenticated user identifier from API key.
     *
     * @param string $apiKey The API key
     * @return string|null The user identifier or null if not authenticated
     */
    public function getUserIdentifier(string $apiKey): ?string;

    /**
     * Extract authentication credentials from the request.
     *
     * @param Request $request The incoming HTTP request
     * @return string|null The credentials or null if not present
     */
    public function extractCredentials(Request $request): ?string;
}
