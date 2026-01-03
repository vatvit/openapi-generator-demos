<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use TictactoeApi\Api\Service\GameManagementApiServiceInterface;
use TictactoeApi\Api\Validator\ListGamesValidator;
use TictactoeApi\Api\Response\ListGames200Response;
use TictactoeApi\Api\Response\ListGames400Response;
use TictactoeApi\Api\Response\ListGames401Response;

/**
 * ListGamesHandler
 *
 * PSR-15 request handler for listGames operation.
 * List all games
 *
 * @generated
 */
final class ListGamesHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly GameManagementApiServiceInterface $service,
        private readonly ListGamesValidator $validator
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
        $result = $this->service->listGames(
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
