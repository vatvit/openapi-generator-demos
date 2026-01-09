<?php

declare(strict_types=1);

namespace PetshopApi\Http\Controllers;

use PetshopApi\Api\PetsHandlerInterface;
use PetshopApi\Http\Requests\DeletePetRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for deletePet operation.
 *
 * deletes a single pet based on the ID supplied
 */
final class DeletePetController
{
    public function __construct(
        private readonly PetsHandlerInterface $handler
    ) {}

    /**
     * Handle the deletePet request.
     *
     * @param DeletePetRequest $request The validated request
     * @param int $id Path parameter: ID of pet to delete
     * @return JsonResponse
     */
    public function __invoke(
        DeletePetRequest $request,
        int $id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->deletePet(
            $id
        );

        return $response;
    }
}
