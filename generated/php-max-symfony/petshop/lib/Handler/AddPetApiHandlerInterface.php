<?php

declare(strict_types=1);

namespace PetshopApi\Handler;

use PetshopApi\Response\AddPet200Response;
use PetshopApi\Response\AddPet0Response;

/**
 * AddPetApiHandlerInterface
 *
 * Handler interface for addPet operation.
 * Implement this to provide business logic.
 *
 *
 * Creates a new pet in the store. Duplicates are allowed
 *
 * @generated
 */
interface AddPetApiHandlerInterface
{
    /**
     *
     * Creates a new pet in the store. Duplicates are allowed
     */
    public function addPet(
        \PetshopApi\Request\AddPetRequest $new_pet
    ): AddPet200Response|AddPet0Response;
}
