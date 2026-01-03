<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;
use TictactoeApi\Api\Response\GetBoard200Response;
use TictactoeApi\Api\Response\GetBoard404Response;

/**
 * GetBoardApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getBoard
 *
 * @generated
 */
interface GetBoardApiHandlerInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function getBoard(
        string $game_id,
    ): GetBoard200Response|GetBoard404Response;

}
