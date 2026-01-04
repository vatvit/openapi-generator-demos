<?php

declare(strict_types=1);

namespace PetshopApi\Handler;

use PetshopApi\Response\FindPetById200Response;
use PetshopApi\Response\FindPetById0Response;

/**
 * FindPetByIdApiHandlerInterface
 *
 * Handler interface for findPetById operation.
 * Implement this to provide business logic.
 *
 *
 * Returns a user based on a single ID, if the user does not have access to the pet
 *
 * @generated
 */
interface FindPetByIdApiHandlerInterface
{
    /**
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     */
    public function findPetById(
        int $id,
    ): FindPetById200Response|FindPetById0Response;
}
