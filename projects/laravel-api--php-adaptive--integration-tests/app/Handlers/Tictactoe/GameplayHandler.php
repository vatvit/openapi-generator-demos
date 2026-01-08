<?php

declare(strict_types=1);

namespace App\Handlers\Tictactoe;

use Illuminate\Http\JsonResponse;
use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Model\MoveRequest;

/**
 * Stub implementation of GameplayHandlerInterface for testing.
 */
class GameplayHandler implements GameplayHandlerInterface
{
    /**
     * Get the game board.
     */
    public function getBoard(string $game_id): JsonResponse
    {
        return new JsonResponse([
            'gameId' => $game_id,
            'board' => [
                ['X', null, 'O'],
                [null, 'X', null],
                ['O', null, null],
            ],
            'currentTurn' => 'X',
            'winner' => null,
        ], 200);
    }

    /**
     * Get game details.
     */
    public function getGame(string $game_id): JsonResponse
    {
        return new JsonResponse([
            'id' => $game_id,
            'status' => 'in_progress',
            'mode' => 'pvp',
            'board' => [
                ['X', null, 'O'],
                [null, 'X', null],
                ['O', null, null],
            ],
            'createdAt' => date('c'),
            'playerX' => [
                'id' => 'player-1',
                'username' => 'player_one',
            ],
            'playerO' => [
                'id' => 'player-2',
                'username' => 'player_two',
            ],
            'currentTurn' => 'X',
        ], 200);
    }

    /**
     * Get move history.
     */
    public function getMoves(string $game_id): JsonResponse
    {
        return new JsonResponse([
            'gameId' => $game_id,
            'moves' => [
                [
                    'moveNumber' => 1,
                    'playerId' => 'player-1',
                    'mark' => 'X',
                    'row' => 0,
                    'column' => 0,
                    'timestamp' => date('c', strtotime('-5 minutes')),
                ],
                [
                    'moveNumber' => 2,
                    'playerId' => 'player-2',
                    'mark' => 'O',
                    'row' => 0,
                    'column' => 2,
                    'timestamp' => date('c', strtotime('-4 minutes')),
                ],
                [
                    'moveNumber' => 3,
                    'playerId' => 'player-1',
                    'mark' => 'X',
                    'row' => 1,
                    'column' => 1,
                    'timestamp' => date('c', strtotime('-3 minutes')),
                ],
                [
                    'moveNumber' => 4,
                    'playerId' => 'player-2',
                    'mark' => 'O',
                    'row' => 2,
                    'column' => 0,
                    'timestamp' => date('c', strtotime('-2 minutes')),
                ],
            ],
        ], 200);
    }

    /**
     * Get a single board square.
     */
    public function getSquare(string $game_id, int $row, int $column): JsonResponse
    {
        $board = [
            ['X', null, 'O'],
            [null, 'X', null],
            ['O', null, null],
        ];

        $mark = $board[$row][$column] ?? null;

        return new JsonResponse([
            'row' => $row,
            'column' => $column,
            'mark' => $mark,
        ], 200);
    }

    /**
     * Set a single board square.
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        MoveRequest $move_request
    ): JsonResponse {
        // Simulate placing a mark
        $board = [
            ['X', null, 'O'],
            [null, 'X', null],
            ['O', null, null],
        ];

        $board[$row][$column] = $move_request->mark;

        // Check for a winner (simplified)
        $winner = null;
        if ($row === 2 && $column === 2 && $move_request->mark === 'X') {
            $winner = 'X'; // Diagonal win
        }

        return new JsonResponse([
            'gameId' => $game_id,
            'board' => $board,
            'currentTurn' => $move_request->mark === 'X' ? 'O' : 'X',
            'winner' => $winner,
            'move' => [
                'row' => $row,
                'column' => $column,
                'mark' => $move_request->mark,
            ],
        ], 200);
    }
}
