<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\PetsApiHandlerInterface;

/**
 * DeletePetController
 *
 * Symfony single-action controller for deletePet operation.
 * Auto-generated from OpenAPI specification.
 *
 * deletes a single pet based on the ID supplied
 *
 * @generated
 */
#[Route('/pets/{id}', name: 'api.deletePet', methods: ['DELETE'])]
final class DeletePetController
{
    public function __construct(
        private readonly PetsApiHandlerInterface $handler,
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
