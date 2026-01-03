<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;
use TictactoeApi\Api\Http\Resources\PutSquare200Resource;
use TictactoeApi\Api\Http\Resources\PutSquare400Resource;
use TictactoeApi\Api\Http\Resources\PutSquare404Resource;
use TictactoeApi\Api\Http\Resources\PutSquare409Resource;

/**
 * PutSquareApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: putSquare
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
        \TictactoeApi\Model\MoveRequest $move_request
    ): PutSquare200Resource|PutSquare400Resource|PutSquare404Resource|PutSquare409Resource;

}
