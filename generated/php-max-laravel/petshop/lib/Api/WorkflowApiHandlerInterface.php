<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use PetshopApi\Model\Error;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Pet;

/**
 * WorkflowApiHandlerInterface
 *
 * Handler interface for WorkflowApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface WorkflowApiHandlerInterface
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
