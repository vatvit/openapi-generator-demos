<?php

declare(strict_types=1);

namespace TicTacToeApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * TicTacHandlerInterface
 *
 * Handler interface for TicTac API operations.
 * Implement this interface to provide business logic.
 */
interface TicTacHandlerInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     *
     * @param string $game_id Unique game identifier
     * @return JsonResponse
     */
    public function getBoard(
        string $game_id
    ): JsonResponse;

}
