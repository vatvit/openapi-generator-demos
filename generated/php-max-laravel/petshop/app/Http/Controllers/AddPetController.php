<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Controllers;

use PetshopApi\Api\Handlers\WorkflowApiHandlerInterface;
use PetshopApi\Api\Http\Requests\AddPetFormRequest;
use PetshopApi\Model\NewPet;
use Illuminate\Http\JsonResponse;

final class AddPetController
{
    public function __construct(
        private readonly WorkflowApiHandlerInterface $handler
    ) {}

    /**
     * Creates a new pet in the store. Duplicates are allowed
     */
    public function __invoke(
        AddPetFormRequest $request
    ): JsonResponse
    {
        // Convert validated data to DTO
        $dto = \PetshopApi\Model\NewPet::fromArray($request->validated());

        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->addPet(
            $dto
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
