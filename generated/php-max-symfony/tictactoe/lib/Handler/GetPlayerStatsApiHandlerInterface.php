<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\GetPlayerStats200Response;
use TictactoeApi\Response\GetPlayerStats404Response;

/**
 * GetPlayerStatsApiHandlerInterface
 *
 * Handler interface for getPlayerStats operation.
 * Implement this to provide business logic.
 *
 * Get player statistics
 *
 * Retrieves comprehensive statistics for a player.
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
