<?php

declare(strict_types=1);

namespace TicTacToeApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * GameManagementHandlerInterface
 *
 * Handler interface for GameManagement API operations.
 * Implement this interface to provide business logic.
 */
interface GameManagementHandlerInterface
{
    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     *
     * @param \TicTacToeApi\Model\CreateGameRequest $create_game_request Request body DTO
     * @return JsonResponse
     */
    public function createGame(
        \TicTacToeApi\Model\CreateGameRequest $create_game_request
    ): JsonResponse;

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     *
     * @param string $game_id Unique game identifier
     * @return JsonResponse
     */
    public function deleteGame(
        string $game_id
    ): JsonResponse;

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param string $game_id Unique game identifier
     * @return JsonResponse
     */
    public function getGame(
        string $game_id
    ): JsonResponse;

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     *
     * @param int|null $page Page number for pagination
     * @param int|null $limit Number of items per page
     * @param \TicTacToeApi\Model\GameStatus|null $status Filter by game status
     * @param string|null $player_id Filter games by player ID
     * @return JsonResponse
     */
    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        \TicTacToeApi\Model\GameStatus|null $status = null,
        string|null $player_id = null
    ): JsonResponse;

}
