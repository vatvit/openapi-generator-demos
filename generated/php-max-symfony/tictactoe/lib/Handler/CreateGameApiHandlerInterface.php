<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;


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
     *
     * @param \TictactoeApi\Model\CreateGameRequest $create_game_request 
     * @return mixed
     */
    public function createGame(
        \TictactoeApi\Model\CreateGameRequest $create_game_request
    );
}
