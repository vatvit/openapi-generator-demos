<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Service;

use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;
use \GetBoard200Response;
use \GetBoard404Response;

/**
 * TicTacApiServiceInterface
 *
 * Service interface for business logic implementation.
 * Implement this interface to provide your business logic.
 *
 * Operation: getBoard
 *
 * @generated
 */
interface TicTacApiServiceInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function getBoard(
        string $game_id
    ): GetBoard200Response|GetBoard404Response;

}
