<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\GetGame200Response;
use TictactoeApi\Response\GetGame404Response;

/**
 * GetGameApiHandlerInterface
 *
 * Handler interface for getGame operation.
 * Implement this to provide business logic.
 *
 * Get game details
 *
 * Retrieves detailed information about a specific game.
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
