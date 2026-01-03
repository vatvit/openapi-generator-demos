<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;

/**
 * RetrievalApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface RetrievalApiInterface
{

    /**
     * Operation findPetById
     *
     * @param  int $id  ID of pet to fetch (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function findPetById(
        int $id,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;
}
