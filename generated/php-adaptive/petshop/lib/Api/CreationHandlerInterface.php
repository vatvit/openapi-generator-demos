<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * CreationHandlerInterface
 *
 * Handler interface for Creation API operations.
 * Implement this interface to provide business logic.
 */
interface CreationHandlerInterface
{
    /**
     * 
     *
     * Creates a new pet in the store. Duplicates are allowed
     *
     * @param \PetshopApi\Model\NewPet $new_pet Request body DTO
     * @return JsonResponse
     */
    public function addPet(
        \PetshopApi\Model\NewPet $new_pet
    ): JsonResponse;

}
