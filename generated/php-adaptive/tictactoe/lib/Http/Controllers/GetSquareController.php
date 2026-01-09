<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Http\Requests\GetSquareRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for getSquare operation.
 *
 * Get a single board square
 *
 * Retrieves the requested square.
 */
final class GetSquareController
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler
    ) {}

    /**
     * Handle the getSquare request.
     *
     * @param GetSquareRequest $request The validated request
     * @param string $game_id Path parameter: Unique game identifier
     * @param int $row Path parameter: Board row (vertical coordinate)
     * @param int $column Path parameter: Board column (horizontal coordinate)
     * @return JsonResponse
     */
    public function __invoke(
        GetSquareRequest $request,
        string $game_id,
        int $row,
        int $column
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->getSquare(
            $game_id,
            $row,
            $column
        );

        return $response;
    }
}
