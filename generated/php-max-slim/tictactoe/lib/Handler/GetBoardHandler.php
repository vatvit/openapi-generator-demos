<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\GetBoardHandlerServiceInterface;
use TictactoeApi\Handler\GetBoardValidator;
use TictactoeApi\Response\GetBoard200Response;
use TictactoeApi\Response\GetBoard404Response;

/**
 * GetBoardHandler
 *
 * PSR-15 request handler for getBoard operation.
 * Get the game board
 *
 * @generated
 */
class GetBoardHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetBoardHandlerServiceInterface $service,
        private readonly GetBoardValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $game_id = $request->getAttribute('game_id');



        // Validate input
        $validationResult = $this->validator->validate([
            'game_id' => $game_id,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->getBoard(
            $game_id
        );

        return $this->jsonResponse($result->getData(), $result->getStatusCode());
    }

    /**
     * Create a JSON response
     */
    private function jsonResponse(mixed $data, int $status = 200): ResponseInterface
    {
        $response = new \Slim\Psr7\Response($status);
        $response->getBody()->write(json_encode($data, JSON_THROW_ON_ERROR));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
