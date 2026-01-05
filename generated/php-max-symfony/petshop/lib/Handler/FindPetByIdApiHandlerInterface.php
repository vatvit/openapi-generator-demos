<?php

declare(strict_types=1);

namespace PetshopApi\Handler;


/**
 * FindPetByIdApiHandlerInterface
 *
 * Handler interface for findPetById operation.
 * Implement this to provide business logic.
 *
 *
 * Returns a user based on a single ID, if the user does not have access to the pet
 *
 * @generated
 */
interface FindPetByIdApiHandlerInterface
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
