<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\Game;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Api\Http\Resources\GetGame200Resource;
use TictactoeApi\Api\Http\Resources\GetGame404Resource;

/**
 * GetGameApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: getGame
 */
interface GetGameApiHandlerInterface
{
    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function getGame(
        string $game_id
    ): GetGame200Resource|GetGame404Resource;

}
