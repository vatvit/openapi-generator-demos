<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\Leaderboard;

/**
 * GetLeaderboardApiInterface
 *
 * API Service interface for GetLeaderboardApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: getLeaderboard
 *
 * @generated
 */
interface GetLeaderboardApiInterface
{
    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     *
     * @param string|null $timeframe Timeframe for leaderboard statistics
     * @param int|null $limit Number of top players to return
     * @return mixed
     */
    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null,
    );

}
