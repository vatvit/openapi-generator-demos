<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handler;

use PetshopApi\Model\Error;
use PetshopApi\Api\Response\DeletePet204Response;
use PetshopApi\Api\Response\DeletePet0Response;

/**
 * AdminApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: deletePet
 *
 * @generated
 */
interface AdminApiHandlerInterface
{
    /**
     *
     * deletes a single pet based on the ID supplied
     */
    public function deletePet(
        int $id,
    ): DeletePet204Response|DeletePet0Response;

}
