<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\TicTacHandlerInterface;
use TicTacToeApi\Http\Requests\GetBoardRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for getBoard operation.
 *
 * Get the game board
 *
 * Retrieves the current state of the board and the winner.
 */
final class GetBoardController
{
    public function __construct(
        private readonly TicTacHandlerInterface $handler
    ) {}

    /**
     * Handle the getBoard request.
     *
     * @param GetBoardRequest $request The validated request
     * @param string $game_id Path parameter: Unique game identifier
     * @return JsonResponse
     */
    public function __invoke(
        GetBoardRequest $request,
        string $game_id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->getBoard(
            $game_id
        );

        return $response;
    }
}
