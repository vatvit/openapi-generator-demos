<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * PetsApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface PetsApiInterface
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
