<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use PetshopApi\Handler\RetrievalHandlerInterface;

/**
 * FindPetByIdController
 *
 * 
 *
 * @generated
 */
class FindPetByIdController extends Controller
{
    public function __construct(
        private readonly RetrievalHandlerInterface $handler,
    ) {
    }

    /**
     * 
     *
     * Returns a user based on a single ID, if the user does not have access to the pet
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->findPetById(
            id: $request->route('id'),
        );

        return response()->json($result);
    }
}
