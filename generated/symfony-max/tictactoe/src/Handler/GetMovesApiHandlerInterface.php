<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Api\Response\GetMoves200Response;
use TictactoeApi\Api\Response\GetMoves404Response;

/**
 * GetMovesApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getMoves
 *
 * @generated
 */
interface GetMovesApiHandlerInterface
{
    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     */
    public function getMoves(
        string $game_id,
    ): GetMoves200Response|GetMoves404Response;

}
