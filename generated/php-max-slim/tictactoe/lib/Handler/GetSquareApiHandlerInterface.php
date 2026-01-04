<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\GetSquareApiHandlerInterfaceServiceInterface;
use TictactoeApi\Handler\GetSquareValidator;
use TictactoeApi\Response\GetSquare200Response;
use TictactoeApi\Response\GetSquare400Response;
use TictactoeApi\Response\GetSquare404Response;

/**
 * GetSquareHandler
 *
 * PSR-15 request handler for getSquare operation.
 * Get a single board square
 *
 * @generated
 */
class GetSquareHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetSquareApiHandlerInterfaceServiceInterface $service,
        private readonly GetSquareValidator $validator
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



        // Validate input
        $validationResult = $this->validator->validate([
            'game_id' => $game_id,
            'row' => $row,
            'column' => $column,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->getSquare(
            $game_id,
            $row,
            $column
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
