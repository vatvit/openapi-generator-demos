<?php

declare(strict_types=1);

namespace PetshopApi\Handler;


/**
 * DeletePetApiHandlerInterface
 *
 * Handler interface for deletePet operation.
 * Implement this to provide business logic.
 *
 *
 * deletes a single pet based on the ID supplied
 *
 * @generated
 */
interface DeletePetApiHandlerInterface
{
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
