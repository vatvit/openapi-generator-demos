<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\CreateGame201Response;
use TictactoeApi\Response\CreateGame400Response;
use TictactoeApi\Response\CreateGame401Response;
use TictactoeApi\Response\CreateGame422Response;

/**
 * CreateGameApiHandlerInterface
 *
 * Handler interface for createGame operation.
 * Implement this to provide business logic.
 *
 * Create a new game
 *
 * Creates a new TicTacToe game with specified configuration.
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
        \TictactoeApi\Request\CreateGameRequest $create_game_request
    ): CreateGame201Response|CreateGame400Response|CreateGame401Response|CreateGame422Response;
}
