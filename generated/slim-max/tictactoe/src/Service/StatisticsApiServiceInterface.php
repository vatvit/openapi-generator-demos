<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Service;

use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;
use \GetLeaderboard200Response;
use \GetPlayerStats200Response;
use \GetPlayerStats404Response;

/**
 * StatisticsApiServiceInterface
 *
 * Service interface for business logic implementation.
 * Implement this interface to provide your business logic.
 *
 * Operation: getLeaderboard
 * Operation: getPlayerStats
 *
 * @generated
 */
interface StatisticsApiServiceInterface
{
    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     */
    public function getLeaderboard(
        string|null $timeframe = 'all-time',
        int|null $limit = 10
    ): GetLeaderboard200Response;

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     */
    public function getPlayerStats(
        string $player_id
    ): GetPlayerStats200Response|GetPlayerStats404Response;

}
