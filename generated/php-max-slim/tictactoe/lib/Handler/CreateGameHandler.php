<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\CreateGameHandlerServiceInterface;
use TictactoeApi\Handler\CreateGameValidator;
use TictactoeApi\Response\CreateGame201Response;
use TictactoeApi\Response\CreateGame400Response;
use TictactoeApi\Response\CreateGame401Response;
use TictactoeApi\Response\CreateGame422Response;

/**
 * CreateGameHandler
 *
 * PSR-15 request handler for createGame operation.
 * Create a new game
 *
 * @generated
 */
class CreateGameHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly CreateGameHandlerServiceInterface $service,
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
            'body' => $body,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->createGame(
            $body
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
