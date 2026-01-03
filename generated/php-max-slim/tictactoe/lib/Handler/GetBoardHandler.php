<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\GetBoardApiServiceInterface;

/**
 * GetBoardHandler
 *
 * PSR-15 request handler for getBoard operation.
 * Get the game board
 *
 * @generated
 */
final class GetBoardHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetBoardApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Get the game board
     * Retrieves the current state of the board and the winner.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $game_id = $request->getAttribute('gameId');

        // Call service
        $result = $this->service->getBoard(
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
