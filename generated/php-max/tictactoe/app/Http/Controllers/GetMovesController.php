<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class GetMovesController
{
    public function __construct(
        private readonly GameplayApiHandlerInterface $handler
    ) {}

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     */
    public function __invoke(
        Request $request,
        string $game_id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->getMoves(
            $game_id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
