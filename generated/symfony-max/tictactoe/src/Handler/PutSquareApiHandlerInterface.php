<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;
use TictactoeApi\Api\Response\PutSquare200Response;
use TictactoeApi\Api\Response\PutSquare400Response;
use TictactoeApi\Api\Response\PutSquare404Response;
use TictactoeApi\Api\Response\PutSquare409Response;

/**
 * PutSquareApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: putSquare
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
        \TictactoeApi\Model\MoveRequest $move_request
    ): PutSquare200Response|PutSquare400Response|PutSquare404Response|PutSquare409Response;

}
