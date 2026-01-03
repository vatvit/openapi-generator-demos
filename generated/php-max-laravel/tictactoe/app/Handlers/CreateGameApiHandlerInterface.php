<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Model\ValidationError;
use TictactoeApi\Api\Http\Resources\CreateGame201Resource;
use TictactoeApi\Api\Http\Resources\CreateGame400Resource;
use TictactoeApi\Api\Http\Resources\CreateGame401Resource;
use TictactoeApi\Api\Http\Resources\CreateGame422Resource;

/**
 * CreateGameApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: createGame
 */
interface CreateGameApiHandlerInterface
{
    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     */
    public function createGame(
        \TictactoeApi\Model\CreateGameRequest $create_game_request
    ): CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource;

}
