<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\ForbiddenError;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Model\ValidationError;

/**
 * GameManagementApiServiceInterface
 *
 * Handler interface for GameManagementApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GameManagementApiServiceInterface
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
        \TictactoeApi\Model\CreateGameRequest $create_game_request,
    );

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function deleteGame(
        string $game_id,
    );

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getGame(
        string $game_id,
    );

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     *
     * @param int $page Page number for pagination
     * @param int $limit Number of items per page
     * @param \TictactoeApi\Model\GameStatus $status Filter by game status
     * @param string $player_id Filter games by player ID
     * @return mixed
     */
    public function listGames(
        int $page,
        int $limit,
        \TictactoeApi\Model\GameStatus $status,
        string $player_id,
    );

}
