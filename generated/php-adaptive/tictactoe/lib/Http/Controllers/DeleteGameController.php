<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Http\Requests\DeleteGameRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for deleteGame operation.
 *
 * Delete a game
 *
 * Deletes a game. Only allowed for game creators or admins.
 */
final class DeleteGameController
{
    public function __construct(
        private readonly GameManagementHandlerInterface $handler
    ) {}

    /**
     * Handle the deleteGame request.
     *
     * @param DeleteGameRequest $request The validated request
     * @param string $game_id Path parameter: Unique game identifier
     * @return JsonResponse
     */
    public function __invoke(
        DeleteGameRequest $request,
        string $game_id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->deleteGame(
            $game_id
        );

        return $response;
    }
}
