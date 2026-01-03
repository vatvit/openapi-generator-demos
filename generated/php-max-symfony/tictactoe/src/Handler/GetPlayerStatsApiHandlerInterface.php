<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;
use TictactoeApi\Api\Response\GetPlayerStats200Response;
use TictactoeApi\Api\Response\GetPlayerStats404Response;

/**
 * GetPlayerStatsApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getPlayerStats
 *
 * @generated
 */
interface GetPlayerStatsApiHandlerInterface
{
    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     */
    public function getPlayerStats(
        string $player_id,
    ): GetPlayerStats200Response|GetPlayerStats404Response;

}
