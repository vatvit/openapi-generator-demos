<?php

declare(strict_types=1);

namespace App\Handlers\Tictactoe;

use Illuminate\Http\JsonResponse;
use TicTacToeApi\Api\StatisticsHandlerInterface;

/**
 * Stub implementation of StatisticsHandlerInterface for testing.
 */
class StatisticsHandler implements StatisticsHandlerInterface
{
    /**
     * Get leaderboard.
     */
    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null
    ): JsonResponse {
        $limit = $limit ?? 10;
        $timeframe = $timeframe ?? 'all_time';

        return new JsonResponse([
            'entries' => [
                [
                    'player' => [
                        'id' => 'player-1',
                        'username' => 'champion',
                    ],
                    'rank' => 1,
                    'score' => 1500,
                    'wins' => 50,
                    'losses' => 10,
                    'draws' => 5,
                ],
                [
                    'player' => [
                        'id' => 'player-2',
                        'username' => 'challenger',
                    ],
                    'rank' => 2,
                    'score' => 1350,
                    'wins' => 40,
                    'losses' => 15,
                    'draws' => 8,
                ],
                [
                    'player' => [
                        'id' => 'player-3',
                        'username' => 'newcomer',
                    ],
                    'rank' => 3,
                    'score' => 1200,
                    'wins' => 25,
                    'losses' => 20,
                    'draws' => 10,
                ],
            ],
            'timeframe' => $timeframe,
            'generatedAt' => date('c'),
        ], 200);
    }

    /**
     * Get player statistics.
     */
    public function getPlayerStats(string $player_id): JsonResponse
    {
        return new JsonResponse([
            'playerId' => $player_id,
            'player' => [
                'id' => $player_id,
                'username' => 'test_player',
            ],
            'gamesPlayed' => 65,
            'wins' => 40,
            'losses' => 15,
            'draws' => 10,
            'winRate' => 0.615,
            'currentStreak' => 3,
            'longestWinStreak' => 8,
        ], 200);
    }
}
