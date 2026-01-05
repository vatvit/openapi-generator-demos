<?php

declare(strict_types=1);

namespace PetshopApi\Handler;


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
     *
     * @param \PetshopApi\Model\NewPet $new_pet Pet to add to the store
     * @return mixed
     */
    public function addPet(
        \PetshopApi\Model\NewPet $new_pet
    );
}
