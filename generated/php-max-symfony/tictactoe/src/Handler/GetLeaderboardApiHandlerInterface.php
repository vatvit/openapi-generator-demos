<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Api\Response\GetLeaderboard200Response;

/**
 * GetLeaderboardApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getLeaderboard
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
