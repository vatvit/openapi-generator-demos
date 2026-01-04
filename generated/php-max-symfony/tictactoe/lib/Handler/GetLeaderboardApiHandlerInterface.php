<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\GetLeaderboard200Response;

/**
 * GetLeaderboardApiHandlerInterface
 *
 * Handler interface for getLeaderboard operation.
 * Implement this to provide business logic.
 *
 * Get leaderboard
 *
 * Retrieves the global leaderboard with top players.
 *
 * @generated
 */
interface GetLeaderboardApiHandlerInterface
{
    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     */
    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null,
    ): GetLeaderboard200Response;
}
