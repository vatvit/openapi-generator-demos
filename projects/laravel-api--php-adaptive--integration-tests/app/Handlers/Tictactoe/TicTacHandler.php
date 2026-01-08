<?php

declare(strict_types=1);

namespace App\Handlers\Tictactoe;

use Illuminate\Http\JsonResponse;
use TicTacToeApi\Api\TicTacHandlerInterface;

/**
 * Stub implementation of TicTacHandlerInterface for testing.
 */
class TicTacHandler implements TicTacHandlerInterface
{
    /**
     * Get the game board.
     */
    public function getBoard(string $game_id): JsonResponse
    {
        return new JsonResponse([
            'gameId' => $game_id,
            'board' => [
                ['X', 'O', null],
                [null, 'X', null],
                [null, null, 'O'],
            ],
            'currentTurn' => 'X',
            'winner' => null,
        ], 200);
    }
}
