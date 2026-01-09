<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * ManagementHandlerInterface
 *
 * Handler interface for Management API operations.
 * Implement this interface to provide business logic.
 */
interface ManagementHandlerInterface
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

    /**
     * 
     *
     * deletes a single pet based on the ID supplied
     *
     * @param int $id ID of pet to delete
     * @return JsonResponse
     */
    public function deletePet(
        int $id
    ): JsonResponse;

}
