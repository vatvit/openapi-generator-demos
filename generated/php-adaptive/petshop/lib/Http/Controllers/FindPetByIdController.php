<?php

declare(strict_types=1);

namespace PetshopApi\Http\Controllers;

use PetshopApi\Api\RetrievalHandlerInterface;
use PetshopApi\Http\Requests\FindPetByIdRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for findPetById operation.
 *
 * Returns a user based on a single ID, if the user does not have access to the pet
 */
final class FindPetByIdController
{
    public function __construct(
        private readonly RetrievalHandlerInterface $handler
    ) {}

    /**
     * Handle the findPetById request.
     *
     * @param FindPetByIdRequest $request The validated request
     * @param int $id Path parameter: ID of pet to fetch
     * @return JsonResponse
     */
    public function __invoke(
        FindPetByIdRequest $request,
        int $id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->findPetById(
            $id
        );

        return $response;
    }
}
