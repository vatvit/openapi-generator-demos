<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\GameplayHandlerInterface;

/**
 * GetSquareController
 *
 * Get a single board square
 *
 * @generated
 */
class GetSquareController extends Controller
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler,
    ) {
    }

    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getSquare(
            game_id: $request->route('gameId'),
            row: $request->route('row'),
            column: $request->route('column'),
        );

        return response()->json($result);
    }
}
