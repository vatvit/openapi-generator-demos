<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;

/**
 * PutSquareApiInterface
 *
 * API Service interface for PutSquareApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: putSquare
 *
 * @generated
 */
interface PutSquareApiInterface
{
    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @param \TictactoeApi\Model\MoveRequest $move_request 
     * @return mixed
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TictactoeApi\Model\MoveRequest $move_request
    );

}
