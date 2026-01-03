<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handlers;

use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;
use PetshopApi\Api\Http\Resources\AddPet200Resource;
use PetshopApi\Api\Http\Resources\AddPet0Resource;
use PetshopApi\Api\Http\Resources\DeletePet204Resource;
use PetshopApi\Api\Http\Resources\DeletePet0Resource;

/**
 * ManagementApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: addPet
 * Operation: deletePet
 */
interface ManagementApiHandlerInterface
{
    /**
     * 
     *
     * Creates a new pet in the store. Duplicates are allowed
     */
    public function addPet(
        \PetshopApi\Model\NewPet $new_pet
    ): AddPet200Resource|AddPet0Resource;

    /**
     * 
     *
     * deletes a single pet based on the ID supplied
     */
    public function deletePet(
        int $id
    ): DeletePet204Resource|DeletePet0Resource;

}
