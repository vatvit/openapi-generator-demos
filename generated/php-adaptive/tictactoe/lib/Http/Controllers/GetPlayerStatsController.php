<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Http\Requests\GetPlayerStatsRequest;
use Illuminate\Http\JsonResponse;

/**
 * Controller for getPlayerStats operation.
 *
 * Get player statistics
 *
 * Retrieves comprehensive statistics for a player.
 */
final class GetPlayerStatsController
{
    public function __construct(
        private readonly StatisticsHandlerInterface $handler
    ) {}

    /**
     * Handle the getPlayerStats request.
     *
     * @param GetPlayerStatsRequest $request The validated request
     * @param string $player_id Path parameter: Unique player identifier
     * @return JsonResponse
     */
    public function __invoke(
        GetPlayerStatsRequest $request,
        string $player_id
    ): JsonResponse {
        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->getPlayerStats(
            $player_id
        );

        return $response;
    }
}
