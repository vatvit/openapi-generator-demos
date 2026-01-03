<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Handler\TicTacHandlerInterface;

/**
 * GetBoardController
 *
 * Get the game board
 *
 * @generated
 */
class GetBoardController extends Controller
{
    public function __construct(
        private readonly TicTacHandlerInterface $handler,
    ) {
    }

    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getBoard(
            game_id: $request->route('gameId'),
        );

        return response()->json($result);
    }
}
