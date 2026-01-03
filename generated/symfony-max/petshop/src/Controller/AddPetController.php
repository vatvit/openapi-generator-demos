<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\WorkflowApiHandlerInterface;
use TictactoeApi\Api\Dto\AddPetRequest as RequestDto;

/**
 * AddPetController
 *
 * Symfony single-action controller for addPet operation.
 * Auto-generated from OpenAPI specification.
 *
 * Creates a new pet in the store. Duplicates are allowed
 *
 * @generated
 */
#[Route('/pets', name: 'api.addPet', methods: ['POST'])]
final class AddPetController
{
    public function __construct(
        private readonly WorkflowApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        #[MapRequestPayload] RequestDto $requestDto
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->addPet(
            $requestDto
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
