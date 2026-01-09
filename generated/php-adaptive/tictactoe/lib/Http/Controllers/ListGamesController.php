<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Http\Requests\ListGamesRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for listGames operation.
 *
 * List all games
 *
 * Retrieves a paginated list of games with optional filtering.
 */
final class ListGamesController
{
    public function __construct(
        private readonly GameManagementHandlerInterface $handler
    ) {}

    /**
     * Handle the listGames request.
     *
     * @param ListGamesRequest $request The validated request
     * @return JsonResponse
     */
    public function __invoke(
        ListGamesRequest $request
    ): JsonResponse {
        // Extract query parameters
        /** @var int $page */
        $page = $request->query('page') !== null
            ? (int) $request->query('page')
            : 1;
        /** @var int $limit */
        $limit = $request->query('limit') !== null
            ? (int) $request->query('limit')
            : 20;
        $statusRaw = $request->query('status', null);
        /** @var \TicTacToeApi\Model\GameStatus|null $status */
        $status = $statusRaw !== null ? \TicTacToeApi\Model\GameStatus::tryFrom($statusRaw) : null;
        /** @var string|null $player_id */
        $player_id = $request->query('playerId', null);

        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->listGames(
            $page,
            $limit,
            $status,
            $player_id
        );

        return $response;
    }
}
