<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\Game;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;

/**
 * GetGameApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getGame
 *
 * @generated
 */
interface GetGameApiHandlerInterface
{
    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function getGame(
        string $game_id,
    ): GetGame200Response|GetGame404Response;

}
