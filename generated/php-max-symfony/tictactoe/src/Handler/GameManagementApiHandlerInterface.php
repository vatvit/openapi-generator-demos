<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\ForbiddenError;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Model\ValidationError;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Api\Response\CreateGame400Response;
use TictactoeApi\Api\Response\CreateGame401Response;
use TictactoeApi\Api\Response\CreateGame422Response;
use TictactoeApi\Api\Response\DeleteGame204Response;
use TictactoeApi\Api\Response\DeleteGame403Response;
use TictactoeApi\Api\Response\DeleteGame404Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\ListGames200Response;
use TictactoeApi\Api\Response\ListGames400Response;
use TictactoeApi\Api\Response\ListGames401Response;

/**
 * GameManagementApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: createGame
 * Operation: deleteGame
 * Operation: getGame
 * Operation: listGames
 *
 * @generated
 */
interface GameManagementHandlerInterface
{
    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     */
    public function createGame(
        \TictactoeApi\Model\CreateGameRequest $create_game_request
    ): CreateGame201Response|CreateGame400Response|CreateGame401Response|CreateGame422Response;

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     */
    public function deleteGame(
        string $game_id,
    ): DeleteGame204Response|DeleteGame403Response|DeleteGame404Response;

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function getGame(
        string $game_id,
    ): GetGame200Response|GetGame404Response;

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     */
    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        \TictactoeApi\Model\GameStatus|null $status = null,
        string|null $player_id = null,
    ): ListGames200Response|ListGames400Response|ListGames401Response;

}
