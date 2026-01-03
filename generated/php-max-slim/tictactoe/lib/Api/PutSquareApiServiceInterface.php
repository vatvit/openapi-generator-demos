<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\BadRequestError;
use TicTacToe\Model\Error;
use TicTacToe\Model\MoveRequest;
use TicTacToe\Model\NotFoundError;
use TicTacToe\Model\Status;

/**
 * PutSquareApiServiceInterface
 *
 * Service interface for PutSquareApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface PutSquareApiServiceInterface
{
    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @param \TicTacToe\Model\MoveRequest $move_request 
     * @return mixed Response data
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TicTacToe\Model\MoveRequest $move_request,
    ): mixed;

}
