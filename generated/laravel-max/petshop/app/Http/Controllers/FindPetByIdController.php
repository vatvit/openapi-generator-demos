<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Controllers;

use PetshopApi\Api\Handlers\RetrievalApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class FindPetByIdController
{
    public function __construct(
        private readonly RetrievalApiHandlerInterface $handler
    ) {}

    /**
     * Returns a user based on a single ID, if the user does not have access to the pet
     */
    public function __invoke(
        Request $request,
        int $id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->findPetById(
            $id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
