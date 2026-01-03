<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\GameManagementHandlerInterface;

/**
 * ListGamesController
 *
 * List all games
 *
 * @generated
 */
class ListGamesController extends Controller
{
    public function __construct(
        private readonly GameManagementHandlerInterface $handler,
    ) {
    }

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->listGames(
            page: $request->query('page'),
            limit: $request->query('limit'),
            status: $request->query('status'),
            player_id: $request->query('playerId'),
        );

        return response()->json($result);
    }
}
