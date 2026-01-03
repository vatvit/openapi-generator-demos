<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;
use TictactoeApi\Api\Http\Resources\GetBoard200Resource;
use TictactoeApi\Api\Http\Resources\GetBoard404Resource;

/**
 * TicTacApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: getBoard
 */
interface TicTacApiHandlerInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function getBoard(
        string $game_id
    ): GetBoard200Resource|GetBoard404Resource;

}
