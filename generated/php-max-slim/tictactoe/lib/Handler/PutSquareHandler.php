<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Model\MoveRequest;
use TicTacToe\Api\PutSquareApiServiceInterface;

/**
 * PutSquareHandler
 *
 * PSR-15 request handler for putSquare operation.
 * Set a single board square
 *
 * @generated
 */
final class PutSquareHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly PutSquareApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Set a single board square
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $game_id = $request->getAttribute('gameId');
        $row = $request->getAttribute('row');
        $column = $request->getAttribute('column');

        // Parse request body
        $bodyData = $request->getParsedBody() ?? [];
        if (is_string($bodyData)) {
            $bodyData = json_decode($bodyData, true) ?? [];
        }
        $move_request = MoveRequest::fromArray($bodyData);

        // Call service
        $result = $this->service->putSquare(
            game_id: $game_id,
            row: $row,
            column: $column,
            move_request: $move_request,
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
