<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\PutSquare200Response;
use TictactoeApi\Response\PutSquare400Response;
use TictactoeApi\Response\PutSquare404Response;
use TictactoeApi\Response\PutSquare409Response;

/**
 * PutSquareApiHandlerInterface
 *
 * Handler interface for putSquare operation.
 * Implement this to provide business logic.
 *
 * Set a single board square
 *
 * Places a mark on the board and retrieves the whole board and the winner (if any).
 *
 * @generated
 */
interface PutSquareApiHandlerInterface
{
    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TictactoeApi\Request\PutSquareRequest $move_request
    ): PutSquare200Response|PutSquare400Response|PutSquare404Response|PutSquare409Response;
}
