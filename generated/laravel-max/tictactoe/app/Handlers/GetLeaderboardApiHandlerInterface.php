<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Api\Http\Resources\GetLeaderboard200Resource;

/**
 * GetLeaderboardApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: getLeaderboard
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
        int|null $limit = null
    ): GetLeaderboard200Resource;

}
