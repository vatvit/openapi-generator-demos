<?php

declare(strict_types=1);

namespace PetshopApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use PetshopApi\Handler\DeletePetApiHandlerInterface;

/**
 * DeletePetController
 *
 * Symfony single-action controller for deletePet operation.
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
#[Route('/pets/{id}', name: 'api.deletePet', methods: ['DELETE'])]
class DeletePetController
{
    public function __construct(
        private readonly DeletePetApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        int $id
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->deletePet(
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
