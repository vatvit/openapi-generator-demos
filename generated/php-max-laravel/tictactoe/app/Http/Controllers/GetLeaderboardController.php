<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GetLeaderboardApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class GetLeaderboardController
{
    public function __construct(
        private readonly GetLeaderboardApiHandlerInterface $handler
    ) {}

    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     */
    public function __invoke(
        Request $request
    ): JsonResponse
    {
        // Extract query parameters
        $timeframe = $request->query('timeframe', 'all-time');
        $limit = (int) $request->query('limit', 10);

        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->getLeaderboard(
            $timeframe,
            $limit
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
