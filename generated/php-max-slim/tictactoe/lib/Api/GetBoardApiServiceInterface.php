<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\NotFoundError;
use TicTacToe\Model\Status;

/**
 * GetBoardApiServiceInterface
 *
 * Service interface for GetBoardApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GetBoardApiServiceInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     *
     * @param string $game_id Unique game identifier
     * @return mixed Response data
     */
    public function getBoard(
        string $game_id,
    ): mixed;

}
