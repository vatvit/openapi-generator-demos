<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\GetMoves200Response;
use TictactoeApi\Response\GetMoves404Response;

/**
 * GetMovesApiHandlerInterface
 *
 * Handler interface for getMoves operation.
 * Implement this to provide business logic.
 *
 * Get move history
 *
 * Retrieves the complete move history for a game.
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
