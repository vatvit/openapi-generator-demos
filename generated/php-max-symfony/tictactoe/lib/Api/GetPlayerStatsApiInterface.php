<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;

/**
 * GetPlayerStatsApiInterface
 *
 * API Service interface for GetPlayerStatsApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: getPlayerStats
 *
 * @generated
 */
interface GetPlayerStatsApiInterface
{
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
