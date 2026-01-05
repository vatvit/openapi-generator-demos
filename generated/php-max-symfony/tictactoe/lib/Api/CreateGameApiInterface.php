<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Model\ValidationError;

/**
 * CreateGameApiInterface
 *
 * API Service interface for CreateGameApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: createGame
 *
 * @generated
 */
interface CreateGameApiInterface
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
