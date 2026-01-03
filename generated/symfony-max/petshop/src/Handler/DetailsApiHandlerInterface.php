<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Error;
use TictactoeApi\Model\Pet;
use TictactoeApi\Api\Response\FindPetById200Response;
use TictactoeApi\Api\Response\FindPetById0Response;

/**
 * DetailsApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: findPetById
 *
 * @generated
 */
interface DetailsApiHandlerInterface
{
    /**
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     */
    public function findPetById(
        int $id,
    ): FindPetById200Response|FindPetById0Response;

}
