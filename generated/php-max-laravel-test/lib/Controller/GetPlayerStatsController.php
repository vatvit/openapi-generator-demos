<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\StatisticsHandlerInterface;

/**
 * GetPlayerStatsController
 *
 * Get player statistics
 *
 * @generated
 */
class GetPlayerStatsController extends Controller
{
    public function __construct(
        private readonly StatisticsHandlerInterface $handler,
    ) {
    }

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getPlayerStats(
            player_id: $request->route('playerId'),
        );

        return response()->json($result);
    }
}
