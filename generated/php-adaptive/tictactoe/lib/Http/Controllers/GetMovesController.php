<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Http\Requests\GetMovesRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for getMoves operation.
 *
 * Get move history
 *
 * Retrieves the complete move history for a game.
 */
final class GetMovesController
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler
    ) {}

    /**
     * Handle the getMoves request.
     *
     * @param GetMovesRequest $request The validated request
     * @param string $game_id Path parameter: Unique game identifier
     * @return JsonResponse
     */
    public function __invoke(
        GetMovesRequest $request,
        string $game_id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->getMoves(
            $game_id
        );

        return $response;
    }
}
