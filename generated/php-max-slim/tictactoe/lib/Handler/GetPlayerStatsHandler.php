<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\GetPlayerStatsApiServiceInterface;

/**
 * GetPlayerStatsHandler
 *
 * PSR-15 request handler for getPlayerStats operation.
 * Get player statistics
 *
 * @generated
 */
final class GetPlayerStatsHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetPlayerStatsApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Get player statistics
     * Retrieves comprehensive statistics for a player.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $player_id = $request->getAttribute('playerId');

        // Call service
        $result = $this->service->getPlayerStats(
            player_id: $player_id,
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
