<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\Error;
use TictactoeApi\Model\NewPet;
use TictactoeApi\Model\Pet;

/**
 * ManagementApiInterface
 *
 * API Service interface for ManagementApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * @generated
 */
interface ManagementApiInterface
{
    /**
     * 
     *
     * Creates a new pet in the store. Duplicates are allowed
     *
     * @param \TictactoeApi\Model\NewPet $new_pet Pet to add to the store
     * @return mixed
     */
    public function addPet(
        \TictactoeApi\Model\NewPet $new_pet,
    );

    /**
     * 
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
