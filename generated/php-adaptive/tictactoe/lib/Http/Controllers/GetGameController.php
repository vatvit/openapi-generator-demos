<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Http\Requests\GetGameRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for getGame operation.
 *
 * Get game details
 *
 * Retrieves detailed information about a specific game.
 */
final class GetGameController
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler
    ) {}

    /**
     * Handle the getGame request.
     *
     * @param GetGameRequest $request The validated request
     * @param string $game_id Path parameter: Unique game identifier
     * @return JsonResponse
     */
    public function __invoke(
        GetGameRequest $request,
        string $game_id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->getGame(
            $game_id
        );

        return $response;
    }
}
