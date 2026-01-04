<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Handler\GetLeaderboardApiHandlerInterface;

/**
 * GetLeaderboardController
 *
 * Symfony single-action controller for getLeaderboard operation.
 * Auto-generated from OpenAPI specification.
 *
 * @generated
 */
#[Route('/leaderboard', name: 'api.getLeaderboard', methods: ['GET'])]
final class GetLeaderboardController
{
    public function __construct(
        private readonly GetLeaderboardApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        Request $request
    ): JsonResponse
    {
        // Extract query parameters
        $timeframe = $request->query->get('timeframe');
        $limit = $request->query->get('limit');

        // Delegate to handler
        $response = $this->handler->getLeaderboard(
            $timeframe,
            $limit,
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
