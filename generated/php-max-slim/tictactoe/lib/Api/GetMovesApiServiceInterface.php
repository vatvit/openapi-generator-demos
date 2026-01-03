<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\MoveHistory;
use TicTacToe\Model\NotFoundError;

/**
 * GetMovesApiServiceInterface
 *
 * Service interface for GetMovesApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GetMovesApiServiceInterface
{
    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed Response data
     */
    public function getMoves(
        string $game_id,
    ): mixed;

}
