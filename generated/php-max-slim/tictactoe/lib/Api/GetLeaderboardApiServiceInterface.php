<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\Leaderboard;

/**
 * GetLeaderboardApiServiceInterface
 *
 * Service interface for GetLeaderboardApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GetLeaderboardApiServiceInterface
{
    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     *
     * @param string|null $timeframe Timeframe for leaderboard statistics
     * @param int|null $limit Number of top players to return
     * @return mixed Response data
     */
    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null,
    ): mixed;

}
