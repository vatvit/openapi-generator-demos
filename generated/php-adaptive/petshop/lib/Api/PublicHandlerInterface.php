<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * PublicHandlerInterface
 *
 * Handler interface for Public API operations.
 * Implement this interface to provide business logic.
 */
interface PublicHandlerInterface
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
