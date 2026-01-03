<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handler;

use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;
use PetshopApi\Api\Response\AddPet200Response;
use PetshopApi\Api\Response\AddPet0Response;

/**
 * WorkflowApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: addPet
 *
 * @generated
 */
interface WorkflowApiHandlerInterface
{
    /**
     *
     * Creates a new pet in the store. Duplicates are allowed
     */
    public function addPet(
        \PetshopApi\Model\NewPet $new_pet
    ): AddPet200Response|AddPet0Response;

}
