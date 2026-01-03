<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\Service\GameManagementApiServiceInterface;
use TictactoeApi\Api\Validator\CreateGameValidator;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Api\Response\CreateGame400Response;
use TictactoeApi\Api\Response\CreateGame401Response;
use TictactoeApi\Api\Response\CreateGame422Response;

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
        private readonly GameManagementApiServiceInterface $service,
        private readonly CreateGameValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {


        // Parse request body
        $body = $request->getParsedBody();

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
        $result = $this->service->createGame(
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
