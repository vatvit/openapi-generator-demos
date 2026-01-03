<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\GetMovesApiServiceInterface;

/**
 * GetMovesHandler
 *
 * PSR-15 request handler for getMoves operation.
 * Get move history
 *
 * @generated
 */
final class GetMovesHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetMovesApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Get move history
     * Retrieves the complete move history for a game.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $game_id = $request->getAttribute('gameId');

        // Call service
        $result = $this->service->getMoves(
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
