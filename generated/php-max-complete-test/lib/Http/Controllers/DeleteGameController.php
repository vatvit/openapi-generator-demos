<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\GameManagementHandlerInterface;

/**
 * DeleteGameController
 *
 * Delete a game
 *
 * @generated
 */
class DeleteGameController extends Controller
{
    public function __construct(
        private readonly GameManagementHandlerInterface $handler,
    ) {
    }

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->deleteGame(
            game_id: $request->route('gameId'),
        );

        return response()->json($result);
    }
}
