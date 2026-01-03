<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;

/**
 * TicTacApiHandlerInterface
 *
 * Handler interface for TicTacApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface TicTacApiHandlerInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getBoard(
        string $game_id,
    );

}
