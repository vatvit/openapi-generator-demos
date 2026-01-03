<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\GetSquareApiHandlerInterface;

/**
 * GetSquareController
 *
 * Symfony single-action controller for getSquare operation.
 * Auto-generated from OpenAPI specification.
 *
 * Get a single board square
 *
 * Retrieves the requested square.
 *
 * @generated
 */
#[Route('/games/{gameId}/board/{row}/{column}', name: 'api.getSquare', methods: ['GET'])]
final class GetSquareController
{
    public function __construct(
        private readonly GetSquareApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        string $game_id,
        int $row,
        int $column
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->getSquare(
            $game_id,
            $row,
            $column,
        );

        // Serialize and return response
        return new JsonResponse(
            $this->serializer->serialize($response->getData(), 'json'),
            $response->getStatusCode(),
            $response->getHeaders(),
            true
        );
    }
}
