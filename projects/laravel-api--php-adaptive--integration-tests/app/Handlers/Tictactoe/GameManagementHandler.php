<?php

declare(strict_types=1);

namespace App\Handlers\Tictactoe;

use Illuminate\Http\JsonResponse;
use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\GameStatus;

/**
 * Stub implementation of GameManagementHandlerInterface for testing.
 */
class GameManagementHandler implements GameManagementHandlerInterface
{
    /**
     * Create a new game.
     */
    public function createGame(CreateGameRequest $create_game_request): JsonResponse
    {
        $gameId = 'game-' . bin2hex(random_bytes(8));

        return new JsonResponse([
            'id' => $gameId,
            'status' => 'pending',
            'mode' => $create_game_request->mode->value,
            'board' => [
                [null, null, null],
                [null, null, null],
                [null, null, null],
            ],
            'createdAt' => date('c'),
        ], 201);
    }

    /**
     * Delete a game.
     */
    public function deleteGame(string $game_id): JsonResponse
    {
        return new JsonResponse(null, 204);
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
                ['X', null, null],
                [null, 'O', null],
                [null, null, null],
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
     * List all games.
     */
    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        GameStatus|null $status = null,
        string|null $player_id = null
    ): JsonResponse {
        $page = $page ?? 1;
        $limit = $limit ?? 10;

        return new JsonResponse([
            'games' => [
                [
                    'id' => 'game-001',
                    'status' => 'completed',
                    'mode' => 'pvp',
                    'board' => [
                        ['X', 'O', 'X'],
                        ['O', 'X', 'O'],
                        ['O', 'X', 'X'],
                    ],
                    'createdAt' => date('c', strtotime('-1 hour')),
                    'winner' => 'X',
                ],
                [
                    'id' => 'game-002',
                    'status' => 'in_progress',
                    'mode' => 'ai_easy',
                    'board' => [
                        ['X', null, null],
                        [null, 'O', null],
                        [null, null, null],
                    ],
                    'createdAt' => date('c'),
                    'currentTurn' => 'X',
                ],
            ],
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => 2,
                'hasNext' => false,
                'hasPrevious' => $page > 1,
            ],
        ], 200);
    }
}
