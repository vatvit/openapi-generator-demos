<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Service;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\ForbiddenError;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Model\ValidationError;
use \CreateGame201Response;
use \CreateGame400Response;
use \CreateGame401Response;
use \CreateGame422Response;
use \DeleteGame204Response;
use \DeleteGame403Response;
use \DeleteGame404Response;
use \GetGame200Response;
use \GetGame404Response;
use \ListGames200Response;
use \ListGames400Response;
use \ListGames401Response;

/**
 * GameManagementApiServiceInterface
 *
 * Service interface for business logic implementation.
 * Implement this interface to provide your business logic.
 *
 * Operation: createGame
 * Operation: deleteGame
 * Operation: getGame
 * Operation: listGames
 *
 * @generated
 */
interface GameManagementApiServiceInterface
{
    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     */
    public function createGame(
        \TictactoeApi\Model\\TictactoeApi\Model\CreateGameRequest $create_game_request
    ): CreateGame201Response|CreateGame400Response|CreateGame401Response|CreateGame422Response;

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     */
    public function deleteGame(
        string $game_id
    ): DeleteGame204Response|DeleteGame403Response|DeleteGame404Response;

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function getGame(
        string $game_id
    ): GetGame200Response|GetGame404Response;

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     */
    public function listGames(
        int|null $page = 1,
        int|null $limit = 20,
        \TictactoeApi\Model\GameStatus|null $status = null,
        string|null $player_id = null
    ): ListGames200Response|ListGames400Response|ListGames401Response;

}
