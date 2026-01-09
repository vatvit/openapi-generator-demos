<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\GameplayHandlerInterface;

/**
 * GetGameController
 *
 * Get game details
 *
 * @generated
 */
class GetGameController extends Controller
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler,
    ) {
    }

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getGame(
            game_id: $request->route('gameId'),
        );

        return response()->json($result);
    }
}
