<?php

declare(strict_types=1);

namespace PetshopApi\Handler;

use PetshopApi\Response\DeletePet204Response;
use PetshopApi\Response\DeletePet0Response;

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
     */
    public function deletePet(
        int $id,
    ): DeletePet204Response|DeletePet0Response;
}
