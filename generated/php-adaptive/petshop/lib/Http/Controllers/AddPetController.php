<?php

declare(strict_types=1);

namespace PetshopApi\Http\Controllers;

use PetshopApi\Api\WorkflowHandlerInterface;
use PetshopApi\Http\Requests\AddPetRequest;
use PetshopApi\Model\NewPet as NewPetDto;
use Illuminate\Http\JsonResponse;

/**
 * Controller for addPet operation.
 *
 * Creates a new pet in the store. Duplicates are allowed
 */
final class AddPetController
{
    public function __construct(
        private readonly WorkflowHandlerInterface $handler
    ) {}

    /**
     * Handle the addPet request.
     *
     * @param AddPetRequest $request The validated request
     * @return JsonResponse
     */
    public function __invoke(
        AddPetRequest $request
    ): JsonResponse {
        // Convert validated request data to DTO
        $dto = NewPetDto::fromArray($request->validated());

        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->addPet(
            $dto
        );

        return $response;
    }
}
