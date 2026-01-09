<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PetshopApi\Handler\PetsHandlerInterface;

/**
 * DeletePetController
 *
 * 
 *
 * @generated
 */
class DeletePetController extends Controller
{
    public function __construct(
        private readonly PetsHandlerInterface $handler,
    ) {
    }

    /**
     * 
     *
     * deletes a single pet based on the ID supplied
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->deletePet(
            id: $request->route('id'),
        );

        return response()->json($result);
    }
}
