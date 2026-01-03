<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handlers;

use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;
use PetshopApi\Api\Http\Resources\FindPetById200Resource;
use PetshopApi\Api\Http\Resources\FindPetById0Resource;

/**
 * RetrievalApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: findPetById
 */
interface RetrievalApiHandlerInterface
{
    /**
     * 
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     */
    public function findPetById(
        int $id
    ): FindPetById200Resource|FindPetById0Resource;

}
