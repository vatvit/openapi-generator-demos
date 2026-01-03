<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handler;

use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;
use PetshopApi\Api\Response\FindPetById200Response;
use PetshopApi\Api\Response\FindPetById0Response;

/**
 * RetrievalApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: findPetById
 *
 * @generated
 */
interface RetrievalApiHandlerInterface
{
    /**
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     */
    public function findPetById(
        int $id,
    ): FindPetById200Response|FindPetById0Response;

}
