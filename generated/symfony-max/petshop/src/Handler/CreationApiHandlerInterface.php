<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Error;
use TictactoeApi\Model\NewPet;
use TictactoeApi\Model\Pet;
use TictactoeApi\Api\Response\AddPet200Response;
use TictactoeApi\Api\Response\AddPet0Response;

/**
 * CreationApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: addPet
 *
 * @generated
 */
interface CreationApiHandlerInterface
{
    /**
     *
     * Creates a new pet in the store. Duplicates are allowed
     */
    public function addPet(
        \TictactoeApi\Model\NewPet $new_pet
    ): AddPet200Response|AddPet0Response;

}
