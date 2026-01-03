<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Api\Http\Resources\GetMoves200Resource;
use TictactoeApi\Api\Http\Resources\GetMoves404Resource;

/**
 * GetMovesApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: getMoves
 */
interface GetMovesApiHandlerInterface
{
    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     */
    public function getMoves(
        string $game_id
    ): GetMoves200Resource|GetMoves404Resource;

}
