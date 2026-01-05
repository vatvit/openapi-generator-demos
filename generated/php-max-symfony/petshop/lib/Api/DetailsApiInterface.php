<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use PetshopApi\Model\Error;
use PetshopApi\Model\Pet;

/**
 * DetailsApiInterface
 *
 * API Service interface for DetailsApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: findPetById
 *
 * @generated
 */
interface DetailsApiInterface
{
    /**
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     *
     * @param int $id ID of pet to fetch
     * @return mixed
     */
    public function findPetById(
        int $id,
    );

}
