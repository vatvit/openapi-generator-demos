<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\Service\StatisticsApiServiceInterface;
use TictactoeApi\Api\Validator\GetLeaderboardValidator;
use TictactoeApi\Api\Response\GetLeaderboard200Response;

/**
 * GetLeaderboardHandler
 *
 * PSR-15 request handler for getLeaderboard operation.
 * Get leaderboard
 *
 * @generated
 */
final class GetLeaderboardHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly StatisticsApiServiceInterface $service,
        private readonly GetLeaderboardValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {



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
        $result = $this->service->getLeaderboard(
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
