<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;

/**
 * StatisticsApiServiceInterface
 *
 * Handler interface for StatisticsApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface StatisticsApiServiceInterface
{
    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     *
     * @param string $timeframe Timeframe for leaderboard statistics
     * @param int $limit Number of top players to return
     * @return mixed
     */
    public function getLeaderboard(
        string $timeframe,
        int $limit,
    );

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     *
     * @param string $player_id Unique player identifier
     * @return mixed
     */
    public function getPlayerStats(
        string $player_id,
    );

}
