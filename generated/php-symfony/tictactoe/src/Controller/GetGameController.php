<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\GameplayApiHandlerInterface;

/**
 * GetGameController
 *
 * Symfony single-action controller for getGame operation.
 * Auto-generated from OpenAPI specification.
 *
 * Get game details
 *
 * Retrieves detailed information about a specific game.
 *
 * @generated
 */
#[Route('/games/{gameId}', name: 'api.getGame', methods: ['GET'])]
final class GetGameController
{
    public function __construct(
        private readonly GameplayApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        string $game_id
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->getGame(
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
