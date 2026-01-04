<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\ListGamesApiHandlerInterfaceServiceInterface;
use TictactoeApi\Handler\ListGamesValidator;
use TictactoeApi\Response\ListGames200Response;
use TictactoeApi\Response\ListGames400Response;
use TictactoeApi\Response\ListGames401Response;

/**
 * ListGamesHandler
 *
 * PSR-15 request handler for listGames operation.
 * List all games
 *
 * @generated
 */
class ListGamesHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ListGamesApiHandlerInterfaceServiceInterface $service,
        private readonly ListGamesValidator $validator
    ) {}

    /**
     * Handle the request
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {

        // Extract query parameters
        $queryParams = $request->getQueryParams();
        $page = $queryParams['page'] ?? 1;
        $page = $page !== null ? (int) $page : null;
        $limit = $queryParams['limit'] ?? 20;
        $limit = $limit !== null ? (int) $limit : null;
        $status = $queryParams['status'] ?? null;
        $player_id = $queryParams['player_id'] ?? null;


        // Validate input
        $validationResult = $this->validator->validate([
            'page' => $page,
            'limit' => $limit,
            'status' => $status,
            'player_id' => $player_id,
        ]);

        if (!$validationResult->isValid()) {
            return $this->jsonResponse(
                ['errors' => $validationResult->getErrors()],
                422
            );
        }

        // Call service with validated parameters
        $result = $this->service->listGames(
            $page,
            $limit,
            $status,
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
