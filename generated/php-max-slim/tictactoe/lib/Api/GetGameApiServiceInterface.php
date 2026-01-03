<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\Game;
use TicTacToe\Model\NotFoundError;

/**
 * GetGameApiServiceInterface
 *
 * Service interface for GetGameApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GetGameApiServiceInterface
{
    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed Response data
     */
    public function getGame(
        string $game_id,
    ): mixed;

}
