<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Error;
use TictactoeApi\Model\NewPet;
use TictactoeApi\Model\Pet;
use TictactoeApi\Api\Response\AddPet200Response;
use TictactoeApi\Api\Response\AddPet0Response;
use TictactoeApi\Api\Response\DeletePet204Response;
use TictactoeApi\Api\Response\DeletePet0Response;

/**
 * ManagementApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: addPet
 * Operation: deletePet
 *
 * @generated
 */
interface ManagementApiHandlerInterface
{
    /**
     *
     * Creates a new pet in the store. Duplicates are allowed
     */
    public function addPet(
        \TictactoeApi\Model\NewPet $new_pet
    ): AddPet200Response|AddPet0Response;

    /**
     *
     * deletes a single pet based on the ID supplied
     */
    public function deletePet(
        int $id,
    ): DeletePet204Response|DeletePet0Response;

}
