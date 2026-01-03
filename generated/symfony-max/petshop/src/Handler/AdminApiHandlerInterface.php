<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Error;
use TictactoeApi\Api\Response\DeletePet204Response;
use TictactoeApi\Api\Response\DeletePet0Response;

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
