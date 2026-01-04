<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\DeleteGame204Response;
use TictactoeApi\Response\DeleteGame403Response;
use TictactoeApi\Response\DeleteGame404Response;

/**
 * DeleteGameApiHandlerInterface
 *
 * Handler interface for deleteGame operation.
 * Implement this to provide business logic.
 *
 * Delete a game
 *
 * Deletes a game. Only allowed for game creators or admins.
 *
 * @generated
 */
interface DeleteGameApiHandlerInterface
{
    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     */
    public function deleteGame(
        string $game_id,
    ): DeleteGame204Response|DeleteGame403Response|DeleteGame404Response;
}
