<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\ListGamesApiServiceInterface;

/**
 * ListGamesHandler
 *
 * PSR-15 request handler for listGames operation.
 * List all games
 *
 * @generated
 */
final class ListGamesHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ListGamesApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * List all games
     * Retrieves a paginated list of games with optional filtering.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract query parameters
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;
        $limit = $queryParams['limit'] ?? 20;
        $status = $queryParams['status'] ?? null;
        $player_id = $queryParams['playerId'] ?? null;

        // Call service
        $result = $this->service->listGames(
            page: $page,
            limit: $limit,
            status: $status,
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
