<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;
use TictactoeApi\Api\Http\Resources\GetPlayerStats200Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats404Resource;

/**
 * GetPlayerStatsApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: getPlayerStats
 */
interface GetPlayerStatsApiHandlerInterface
{
    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     */
    public function getPlayerStats(
        string $player_id
    ): GetPlayerStats200Resource|GetPlayerStats404Resource;

}
