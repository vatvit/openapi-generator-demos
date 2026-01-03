<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\Service\GameManagementApiServiceInterface;
use TictactoeApi\Api\Validator\DeleteGameValidator;
use TictactoeApi\Api\Response\DeleteGame204Response;
use TictactoeApi\Api\Response\DeleteGame403Response;
use TictactoeApi\Api\Response\DeleteGame404Response;

/**
 * DeleteGameHandler
 *
 * PSR-15 request handler for deleteGame operation.
 * Delete a game
 *
 * @generated
 */
final class DeleteGameHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GameManagementApiServiceInterface $service,
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
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->deleteGame(
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
