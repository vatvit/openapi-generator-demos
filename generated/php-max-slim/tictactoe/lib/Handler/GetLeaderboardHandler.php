<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\GetLeaderboardApiServiceInterface;

/**
 * GetLeaderboardHandler
 *
 * PSR-15 request handler for getLeaderboard operation.
 * Get leaderboard
 *
 * @generated
 */
final class GetLeaderboardHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetLeaderboardApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Get leaderboard
     * Retrieves the global leaderboard with top players.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract query parameters
        $queryParams = $request->getQueryParams();
        $timeframe = $queryParams['timeframe'] ?? 'all-time';
        $limit = $queryParams['limit'] ?? 10;

        // Call service
        $result = $this->service->getLeaderboard(
            timeframe: $timeframe,
            limit: $limit,
        );

        return $this->jsonResponse($result);
    }

    /**
     * Create JSON response
     */
    private function jsonResponse(mixed $data, int $status = 200): ResponseInterface
    {
        $response = new Response($status);
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));

        return $response->withHeader('Content-Type', 'application/json');
    }
}
