<?php

declare(strict_types=1);

namespace PetshopApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * AdminHandlerInterface
 *
 * Handler interface for Admin API operations.
 * Implement this interface to provide business logic.
 */
interface AdminHandlerInterface
{
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
