<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Controllers;

use PetshopApi\Api\Handlers\PetsApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class DeletePetController
{
    public function __construct(
        private readonly PetsApiHandlerInterface $handler
    ) {}

    /**
     * deletes a single pet based on the ID supplied
     */
    public function __invoke(
        Request $request,
        int $id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->deletePet(
            $id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
