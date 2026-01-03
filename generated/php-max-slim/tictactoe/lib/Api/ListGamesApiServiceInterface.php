<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\BadRequestError;
use TicTacToe\Model\GameListResponse;
use TicTacToe\Model\GameStatus;
use TicTacToe\Model\UnauthorizedError;

/**
 * ListGamesApiServiceInterface
 *
 * Service interface for ListGamesApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface ListGamesApiServiceInterface
{
    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     *
     * @param int|null $page Page number for pagination
     * @param int|null $limit Number of items per page
     * @param \TicTacToe\Model\GameStatus|null $status Filter by game status
     * @param string|null $player_id Filter games by player ID
     * @return mixed Response data
     */
    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        \TicTacToe\Model\GameStatus|null $status = null,
        string|null $player_id = null,
    ): mixed;

}
