<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * RetrievalHandlerInterface
 *
 * Handler interface for Retrieval API operations.
 * Implement this interface to provide business logic.
 */
interface RetrievalHandlerInterface
{
    /**
     * 
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     *
     * @param int $id ID of pet to fetch
     * @return JsonResponse
     */
    public function findPetById(
        int $id
    ): JsonResponse;

}
