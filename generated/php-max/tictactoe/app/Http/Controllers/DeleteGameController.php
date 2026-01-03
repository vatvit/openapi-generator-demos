<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class DeleteGameController
{
    public function __construct(
        private readonly GameManagementApiHandlerInterface $handler
    ) {}

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     */
    public function __invoke(
        Request $request,
        string $game_id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->deleteGame(
            $game_id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
