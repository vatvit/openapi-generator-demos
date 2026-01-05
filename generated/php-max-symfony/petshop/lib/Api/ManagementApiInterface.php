<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * ManagementApiInterface
 *
 * API Service interface for ManagementApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: addPet
 * Operation: deletePet
 *
 * @generated
 */
interface ManagementApiInterface
{
    /**
     *
     * Creates a new pet in the store. Duplicates are allowed
     *
     * @param \PetshopApi\Model\NewPet $new_pet Pet to add to the store
     * @return mixed
     */
    public function addPet(
        \PetshopApi\Model\NewPet $new_pet
    );

    /**
     *
     * deletes a single pet based on the ID supplied
     *
     * @param int $id ID of pet to delete
     * @return mixed
     */
    public function deletePet(
        int $id,
    );

}
