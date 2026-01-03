<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\ForbiddenError;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Api\Response\DeleteGame204Response;
use TictactoeApi\Api\Response\DeleteGame403Response;
use TictactoeApi\Api\Response\DeleteGame404Response;

/**
 * DeleteGameApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: deleteGame
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
