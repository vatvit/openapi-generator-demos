<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\GetPlayerStatsApiHandlerInterfaceServiceInterface;
use TictactoeApi\Handler\GetPlayerStatsValidator;
use TictactoeApi\Response\GetPlayerStats200Response;
use TictactoeApi\Response\GetPlayerStats404Response;

/**
 * GetPlayerStatsHandler
 *
 * PSR-15 request handler for getPlayerStats operation.
 * Get player statistics
 *
 * @generated
 */
class GetPlayerStatsHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetPlayerStatsApiHandlerInterfaceServiceInterface $service,
        private readonly GetPlayerStatsValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Extract path parameters
        $player_id = $request->getAttribute('player_id');



        // Validate input
        $validationResult = $this->validator->validate([
            'player_id' => $player_id,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->getPlayerStats(
            $player_id
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
