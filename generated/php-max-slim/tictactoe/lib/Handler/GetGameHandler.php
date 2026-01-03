<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\GetGameApiServiceInterface;

/**
 * GetGameHandler
 *
 * PSR-15 request handler for getGame operation.
 * Get game details
 *
 * @generated
 */
final class GetGameHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetGameApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Get game details
     * Retrieves detailed information about a specific game.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $game_id = $request->getAttribute('gameId');

        // Call service
        $result = $this->service->getGame(
            game_id: $game_id,
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
