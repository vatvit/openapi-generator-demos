<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\ListGamesApiHandlerInterface;

/**
 * ListGamesController
 *
 * Symfony single-action controller for listGames operation.
 * Auto-generated from OpenAPI specification.
 *
 * List all games
 *
 * Retrieves a paginated list of games with optional filtering.
 *
 * @generated
 */
#[Route('/games', name: 'api.listGames', methods: ['GET'])]
final class ListGamesController
{
    public function __construct(
        private readonly ListGamesApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        Request $request
    ): JsonResponse
    {
        // Extract query parameters
        $page = $request->query->get('page');
        $limit = $request->query->get('limit');
        $status = $request->query->get('status');
        $player_id = $request->query->get('playerId');

        // Delegate to handler
        $response = $this->handler->listGames(
            $page,
            $limit,
            $status,
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
