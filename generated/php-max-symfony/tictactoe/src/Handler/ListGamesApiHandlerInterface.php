<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\UnauthorizedError;
use TictactoeApi\Api\Response\ListGames200Response;
use TictactoeApi\Api\Response\ListGames400Response;
use TictactoeApi\Api\Response\ListGames401Response;

/**
 * ListGamesApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: listGames
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
