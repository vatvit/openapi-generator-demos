<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class ListGamesController
{
    public function __construct(
        private readonly GameManagementApiHandlerInterface $handler
    ) {}

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     */
    public function __invoke(
        Request $request
    ): JsonResponse
    {
        // Extract query parameters
        $page = (int) $request->query('page', 1);
        $limit = (int) $request->query('limit', 20);
        $status = $request->query('status', null);
        $player_id = $request->query('playerId', null);

        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->listGames(
            $page,
            $limit,
            $status,
            $player_id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
