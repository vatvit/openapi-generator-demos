<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Api\GetSquareApiServiceInterface;

/**
 * GetSquareHandler
 *
 * PSR-15 request handler for getSquare operation.
 * Get a single board square
 *
 * @generated
 */
final class GetSquareHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetSquareApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Get a single board square
     * Retrieves the requested square.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $game_id = $request->getAttribute('gameId');
        $row = $request->getAttribute('row');
        $column = $request->getAttribute('column');

        // Call service
        $result = $this->service->getSquare(
            game_id: $game_id,
            row: $row,
            column: $column,
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
