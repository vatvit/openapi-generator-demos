<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;
use TictactoeApi\Api\Response\GetLeaderboard200Response;
use TictactoeApi\Api\Response\GetPlayerStats200Response;
use TictactoeApi\Api\Response\GetPlayerStats404Response;

/**
 * StatisticsApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getLeaderboard
 * Operation: getPlayerStats
 *
 * @generated
 */
interface StatisticsApiHandlerInterface
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

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     */
    public function getPlayerStats(
        string $player_id,
    ): GetPlayerStats200Response|GetPlayerStats404Response;

}
