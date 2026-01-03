<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GetPlayerStatsApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class GetPlayerStatsController
{
    public function __construct(
        private readonly GetPlayerStatsApiHandlerInterface $handler
    ) {}

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     */
    public function __invoke(
        Request $request,
        string $player_id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->getPlayerStats(
            $player_id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
