<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PetshopApi\Request\AddPetFormRequest;
use PetshopApi\Handler\WorkflowHandlerInterface;

/**
 * AddPetController
 *
 * 
 *
 * @generated
 */
class AddPetController extends Controller
{
    public function __construct(
        private readonly WorkflowHandlerInterface $handler,
    ) {
    }

    /**
     * 
     *
     * Creates a new pet in the store. Duplicates are allowed
     *
     * @param AddPetFormRequest $request
     * @return JsonResponse
     */
    public function __invoke(AddPetFormRequest $request): JsonResponse
    {
        $result = $this->handler->addPet(
            new_pet: $request->validated(),
        );

        return response()->json($result);
    }
}
