<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\ListGames200Response;
use TictactoeApi\Response\ListGames400Response;
use TictactoeApi\Response\ListGames401Response;

/**
 * ListGamesApiHandlerInterface
 *
 * Handler interface for listGames operation.
 * Implement this to provide business logic.
 *
 * List all games
 *
 * Retrieves a paginated list of games with optional filtering.
 *
 * @generated
 */
interface ListGamesApiHandlerInterface
{
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
