<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\GetLeaderboardHandlerServiceInterface;
use TictactoeApi\Handler\GetLeaderboardValidator;
use TictactoeApi\Response\GetLeaderboard200Response;

/**
 * GetLeaderboardHandler
 *
 * PSR-15 request handler for getLeaderboard operation.
 * Get leaderboard
 *
 * @generated
 */
class GetLeaderboardHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GetLeaderboardHandlerServiceInterface $service,
        private readonly GetLeaderboardValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // Extract query parameters
        $queryParams = $request->getQueryParams();
        $timeframe = $queryParams['timeframe'] ?? 'all-time';
        $limit = $queryParams['limit'] ?? 10;
        $limit = $limit !== null ? (int) $limit : null;


        // Validate input
        $validationResult = $this->validator->validate([
            'timeframe' => $timeframe,
            'limit' => $limit,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->getLeaderboard(
            $timeframe,
            $limit
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
