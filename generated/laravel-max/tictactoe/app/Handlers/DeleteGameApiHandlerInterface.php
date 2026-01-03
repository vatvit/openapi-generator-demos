<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\ForbiddenError;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Api\Http\Resources\DeleteGame204Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame403Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame404Resource;

/**
 * DeleteGameApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: deleteGame
 */
interface DeleteGameApiHandlerInterface
{
    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     */
    public function deleteGame(
        string $game_id
    ): DeleteGame204Resource|DeleteGame403Resource|DeleteGame404Resource;

}
