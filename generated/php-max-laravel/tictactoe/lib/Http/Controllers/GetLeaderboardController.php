<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\StatisticsHandlerInterface;

/**
 * GetLeaderboardController
 *
 * Get leaderboard
 *
 * @generated
 */
class GetLeaderboardController extends Controller
{
    public function __construct(
        private readonly StatisticsHandlerInterface $handler,
    ) {
    }

    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getLeaderboard(
            timeframe: $request->query('timeframe'),
            limit: $request->query('limit'),
        );

        return response()->json($result);
    }
}
