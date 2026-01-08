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
use PetshopApi\Api\Http\Resources\FindPetById200Resource;
use PetshopApi\Api\Http\Resources\FindPetById0Resource;
use PetshopApi\Api\Http\Resources\FindPets200Resource;
use PetshopApi\Api\Http\Resources\FindPets0Resource;

/**
 * PetsApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: addPet
 * Operation: deletePet
 * Operation: findPetById
 * Operation: findPets
 */
interface PetsApiHandlerInterface
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

    /**
     * 
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     */
    public function findPetById(
        int $id
    ): FindPetById200Resource|FindPetById0Resource;

    /**
     * Returns all pets from the system that the user has access to.
     *
     * @param array<string>|null $tags tags to filter by
     * @param int|null $limit maximum number of results to return
     */
    public function findPets(
        array|null $tags = null,
        int|null $limit = null
    ): FindPets200Resource|FindPets0Resource;

}
