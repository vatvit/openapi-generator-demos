<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\Service\GameplayApiServiceInterface;
use TictactoeApi\Api\Validator\PutSquareValidator;
use TictactoeApi\Api\Response\PutSquare200Response;
use TictactoeApi\Api\Response\PutSquare400Response;
use TictactoeApi\Api\Response\PutSquare404Response;
use TictactoeApi\Api\Response\PutSquare409Response;

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
        private readonly GameplayApiServiceInterface $service,
        private readonly PutSquareValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        // Extract path parameters
        // Extract path parameters
        $game_id = $request->getAttribute('game_id');
        $row = $request->getAttribute('row');
        $row = (int) $row;
        $column = $request->getAttribute('column');
        $column = (int) $column;


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
        $result = $this->service->putSquare(
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
