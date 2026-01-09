<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * WorkflowHandlerInterface
 *
 * Handler interface for Workflow API operations.
 * Implement this interface to provide business logic.
 */
interface WorkflowHandlerInterface
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
