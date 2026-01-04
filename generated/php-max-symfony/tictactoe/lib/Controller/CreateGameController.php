<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Handler\CreateGameApiHandlerInterface;
use TictactoeApi\Request\CreateGameRequest as RequestDto;

/**
 * CreateGameController
 *
 * Symfony single-action controller for createGame operation.
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
#[Route('/games', name: 'api.createGame', methods: ['POST'])]
final class CreateGameController
{
    public function __construct(
        private readonly CreateGameApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        #[MapRequestPayload] RequestDto $requestDto
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->createGame(
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
