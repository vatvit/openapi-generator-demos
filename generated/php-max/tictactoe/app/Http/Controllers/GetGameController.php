<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class GetGameController
{
    public function __construct(
        private readonly GameplayApiHandlerInterface $handler
    ) {}

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function __invoke(
        Request $request,
        string $game_id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->getGame(
            $game_id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
