<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Handler\DeleteGameApiHandlerInterface;

/**
 * DeleteGameController
 *
 * Symfony single-action controller for deleteGame operation.
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
#[Route('/games/{gameId}', name: 'api.deleteGame', methods: ['DELETE'])]
final class DeleteGameController
{
    public function __construct(
        private readonly DeleteGameApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        string $game_id
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->deleteGame(
            $game_id,
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
