<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\BadRequestError;
use TicTacToe\Model\CreateGameRequest;
use TicTacToe\Model\Game;
use TicTacToe\Model\UnauthorizedError;
use TicTacToe\Model\ValidationError;

/**
 * CreateGameApiServiceInterface
 *
 * Service interface for CreateGameApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface CreateGameApiServiceInterface
{
    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     *
     * @param \TicTacToe\Model\CreateGameRequest $create_game_request 
     * @return mixed Response data
     */
    public function createGame(
        \TicTacToe\Model\CreateGameRequest $create_game_request,
    ): mixed;

}
