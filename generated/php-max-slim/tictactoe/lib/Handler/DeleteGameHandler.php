<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\DeleteGameHandlerServiceInterface;
use TictactoeApi\Handler\DeleteGameValidator;
use TictactoeApi\Response\DeleteGame204Response;
use TictactoeApi\Response\DeleteGame403Response;
use TictactoeApi\Response\DeleteGame404Response;

/**
 * DeleteGameHandler
 *
 * PSR-15 request handler for deleteGame operation.
 * Delete a game
 *
 * @generated
 */
class DeleteGameHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly DeleteGameHandlerServiceInterface $service,
        private readonly DeleteGameValidator $validator
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
        $result = $this->service->deleteGame(
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
