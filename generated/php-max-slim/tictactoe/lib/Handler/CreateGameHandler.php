<?php

declare(strict_types=1);

namespace TicTacToe\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;
use TicTacToe\Model\CreateGameRequest;
use TicTacToe\Api\CreateGameApiServiceInterface;

/**
 * CreateGameHandler
 *
 * PSR-15 request handler for createGame operation.
 * Create a new game
 *
 * @generated
 */
final class CreateGameHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly CreateGameApiServiceInterface $service,
    ) {
    }

    /**
     * Handle the request
     *
     * Create a new game
     * Creates a new TicTacToe game with specified configuration.
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Parse request body
        $bodyData = $request->getParsedBody() ?? [];
        if (is_string($bodyData)) {
            $bodyData = json_decode($bodyData, true) ?? [];
        }
        $create_game_request = CreateGameRequest::fromArray($bodyData);

        // Call service
        $result = $this->service->createGame(
            create_game_request: $create_game_request,
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
