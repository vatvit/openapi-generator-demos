<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\GetBoard200Response;
use TictactoeApi\Response\GetBoard404Response;

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
     */
    public function getBoard(
        string $game_id,
    ): GetBoard200Response|GetBoard404Response;
}
