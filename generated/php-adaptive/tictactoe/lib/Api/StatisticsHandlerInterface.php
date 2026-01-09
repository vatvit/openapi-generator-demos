<?php

declare(strict_types=1);

namespace TicTacToeApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * StatisticsHandlerInterface
 *
 * Handler interface for Statistics API operations.
 * Implement this interface to provide business logic.
 */
interface StatisticsHandlerInterface
{
    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     *
     * @param string|null $timeframe Timeframe for leaderboard statistics
     * @param int|null $limit Number of top players to return
     * @return JsonResponse
     */
    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null
    ): JsonResponse;

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     *
     * @param string $player_id Unique player identifier
     * @return JsonResponse
     */
    public function getPlayerStats(
        string $player_id
    ): JsonResponse;

}
