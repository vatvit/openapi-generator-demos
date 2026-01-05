<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\NotFoundError;

/**
 * GetMovesApiInterface
 *
 * API Service interface for GetMovesApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: getMoves
 *
 * @generated
 */
interface GetMovesApiInterface
{
    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getMoves(
        string $game_id,
    );

}
