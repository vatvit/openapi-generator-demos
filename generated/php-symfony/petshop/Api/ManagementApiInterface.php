<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * ManagementApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface ManagementApiInterface
{

    /**
     * Operation addPet
     *
     * @param  NewPet $newPet  Pet to add to the store (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function addPet(
        NewPet $newPet,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;

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
