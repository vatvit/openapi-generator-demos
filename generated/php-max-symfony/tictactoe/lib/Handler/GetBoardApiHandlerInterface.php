<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;


/**
 * GetBoardApiHandlerInterface
 *
 * Handler interface for getBoard operation.
 * Implement this to provide business logic.
 *
 * Get the game board
 *
 * Retrieves the current state of the board and the winner.
 *
 * @generated
 */
interface GetBoardApiHandlerInterface
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
