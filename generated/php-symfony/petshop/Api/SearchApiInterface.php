<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;

/**
 * SearchApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface SearchApiInterface
{

    /**
     * Operation findPets
     *
     * @param  array|null $tags  tags to filter by (optional)
     * @param  int|null $limit  maximum number of results to return (optional)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function findPets(
        ?array $tags,
        ?int $limit,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;
}
