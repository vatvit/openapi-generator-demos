<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use PetshopApi\Model\Error;

/**
 * AdminApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface AdminApiInterface
{

    /**
     * Operation deletePet
     *
     * @param  int $id  ID of pet to delete (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return void
     */
    public function deletePet(
        int $id,
        int &$responseCode,
        array &$responseHeaders
    ): void;
}
