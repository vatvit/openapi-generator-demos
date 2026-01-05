<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;

/**
 * GetBoardApiInterface
 *
 * API Service interface for GetBoardApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: getBoard
 *
 * @generated
 */
interface GetBoardApiInterface
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
