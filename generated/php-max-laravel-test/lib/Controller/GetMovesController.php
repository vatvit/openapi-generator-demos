<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\GameplayHandlerInterface;

/**
 * GetMovesController
 *
 * Get move history
 *
 * @generated
 */
class GetMovesController extends Controller
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler,
    ) {
    }

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getMoves(
            game_id: $request->route('gameId'),
        );

        return response()->json($result);
    }
}
