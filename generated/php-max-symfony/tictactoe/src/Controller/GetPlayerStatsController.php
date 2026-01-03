<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\GetPlayerStatsApiHandlerInterface;

/**
 * GetPlayerStatsController
 *
 * Symfony single-action controller for getPlayerStats operation.
 * Auto-generated from OpenAPI specification.
 *
 * Get player statistics
 *
 * Retrieves comprehensive statistics for a player.
 *
 * @generated
 */
#[Route('/players/{playerId}/stats', name: 'api.getPlayerStats', methods: ['GET'])]
final class GetPlayerStatsController
{
    public function __construct(
        private readonly GetPlayerStatsApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        string $player_id
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->getPlayerStats(
            $player_id,
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
