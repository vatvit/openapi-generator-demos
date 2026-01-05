<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\Game;
use TictactoeApi\Model\NotFoundError;

/**
 * GetGameApiInterface
 *
 * API Service interface for GetGameApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: getGame
 *
 * @generated
 */
interface GetGameApiInterface
{
    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getGame(
        string $game_id,
    );

}
