<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use PetshopApi\Handler\FindPetByIdApiHandlerInterface;

/**
 * FindPetByIdController
 *
 * Symfony single-action controller for findPetById operation.
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
#[Route('/pets/{id}', name: 'api.findPetById', methods: ['GET'])]
final class FindPetByIdController
{
    public function __construct(
        private readonly FindPetByIdApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        int $id
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->findPetById(
            $id,
        );

        // Serialize and return response
        return new JsonResponse(
            $this->serializer->serialize($response->getData(), 'json'),
            $response->getStatusCode(),
            $response->getHeaders(),
            true
        );
    }
}
