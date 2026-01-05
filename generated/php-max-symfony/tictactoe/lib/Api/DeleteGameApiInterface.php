<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\ForbiddenError;
use TictactoeApi\Model\NotFoundError;

/**
 * DeleteGameApiInterface
 *
 * API Service interface for DeleteGameApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: deleteGame
 *
 * @generated
 */
interface DeleteGameApiInterface
{
    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function deleteGame(
        string $game_id,
    );

}
