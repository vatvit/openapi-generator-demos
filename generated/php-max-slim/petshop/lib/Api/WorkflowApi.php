<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * WorkflowApiInterface
 *
 * API Service interface for WorkflowApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * @generated
 */
interface WorkflowApiInterface
{
    /**
     * 
     *
     * Creates a new pet in the store. Duplicates are allowed
     *
     * @param \PetshopApi\Model\NewPet $new_pet Pet to add to the store
     * @return mixed
     */
    public function addPet(
        \PetshopApi\Model\NewPet $new_pet,
    );

}
