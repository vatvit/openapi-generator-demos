<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Model\ValidationError;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Api\Response\CreateGame400Response;
use TictactoeApi\Api\Response\CreateGame401Response;
use TictactoeApi\Api\Response\CreateGame422Response;

/**
 * CreateGameApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: createGame
 *
 * @generated
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
    ): CreateGame201Response|CreateGame400Response|CreateGame401Response|CreateGame422Response;

}
