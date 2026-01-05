<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\UnauthorizedError;

/**
 * ListGamesApiInterface
 *
 * API Service interface for ListGamesApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: listGames
 *
 * @generated
 */
interface ListGamesApiInterface
{
    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     *
     * @param int|null $page Page number for pagination
     * @param int|null $limit Number of items per page
     * @param \TictactoeApi\Model\GameStatus|null $status Filter by game status
     * @param string|null $player_id Filter games by player ID
     * @return mixed
     */
    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        \TictactoeApi\Model\GameStatus|null $status = null,
        string|null $player_id = null,
    );

}
