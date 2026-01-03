<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Api\Http\Resources\ListGames200Resource;
use TictactoeApi\Api\Http\Resources\ListGames400Resource;
use TictactoeApi\Api\Http\Resources\ListGames401Resource;

/**
 * ListGamesApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: listGames
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
        string|null $player_id = null
    ): ListGames200Resource|ListGames400Resource|ListGames401Resource;

}
