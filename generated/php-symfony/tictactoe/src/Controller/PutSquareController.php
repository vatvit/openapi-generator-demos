<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use TictactoeApi\Api\Handler\GameplayApiHandlerInterface;
use TictactoeApi\Api\Dto\PutSquareRequest as RequestDto;

/**
 * PutSquareController
 *
 * Symfony single-action controller for putSquare operation.
 * Auto-generated from OpenAPI specification.
 *
 * Set a single board square
 *
 * Places a mark on the board and retrieves the whole board and the winner (if any).
 *
 * @generated
 */
#[Route('/games/{gameId}/board/{row}/{column}', name: 'api.putSquare', methods: ['PUT'])]
final class PutSquareController
{
    public function __construct(
        private readonly GameplayApiHandlerInterface $handler,
        private readonly SerializerInterface $serializer
    ) {}

    public function __invoke(
        #[MapRequestPayload] RequestDto $requestDto,
        string $game_id,
        int $row,
        int $column
    ): JsonResponse
    {

        // Delegate to handler
        $response = $this->handler->putSquare(
            $game_id,
            $row,
            $column,
            $requestDto
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
