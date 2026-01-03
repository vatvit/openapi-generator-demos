<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\ForbiddenError;
use TicTacToe\Model\NotFoundError;

/**
 * DeleteGameApiServiceInterface
 *
 * Service interface for DeleteGameApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface DeleteGameApiServiceInterface
{
    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     *
     * @param string $game_id Unique game identifier
     * @return mixed Response data
     */
    public function deleteGame(
        string $game_id,
    ): mixed;

}
