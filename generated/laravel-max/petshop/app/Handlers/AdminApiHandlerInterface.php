<?php

declare(strict_types=1);

namespace PetshopApi\Api\Handlers;

use PetshopApi\Model\Error;
use PetshopApi\Api\Http\Resources\DeletePet204Resource;
use PetshopApi\Api\Http\Resources\DeletePet0Resource;

/**
 * AdminApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: deletePet
 */
interface AdminApiHandlerInterface
{
    /**
     * 
     *
     * deletes a single pet based on the ID supplied
     */
    public function deletePet(
        int $id
    ): DeletePet204Resource|DeletePet0Resource;

}
