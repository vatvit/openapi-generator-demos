<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\NotFoundError;
use TicTacToe\Model\PlayerStats;

/**
 * GetPlayerStatsApiServiceInterface
 *
 * Service interface for GetPlayerStatsApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GetPlayerStatsApiServiceInterface
{
    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     *
     * @param string $player_id Unique player identifier
     * @return mixed Response data
     */
    public function getPlayerStats(
        string $player_id,
    ): mixed;

}
