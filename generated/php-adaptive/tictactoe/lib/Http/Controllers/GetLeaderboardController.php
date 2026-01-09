<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Http\Requests\GetLeaderboardRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for getLeaderboard operation.
 *
 * Get leaderboard
 *
 * Retrieves the global leaderboard with top players.
 */
final class GetLeaderboardController
{
    public function __construct(
        private readonly StatisticsHandlerInterface $handler
    ) {}

    /**
     * Handle the getLeaderboard request.
     *
     * @param GetLeaderboardRequest $request The validated request
     * @return JsonResponse
     */
    public function __invoke(
        GetLeaderboardRequest $request
    ): JsonResponse {
        // Extract query parameters
        /** @var string|null $timeframe */
        $timeframe = $request->query('timeframe', 'all-time');
        /** @var int $limit */
        $limit = $request->query('limit') !== null
            ? (int) $request->query('limit')
            : 10;

        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->getLeaderboard(
            $timeframe,
            $limit
        );

        return $response;
    }
}
