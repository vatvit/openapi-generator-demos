<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Request\PutSquareFormRequest;
use TictactoeApi\Handler\GameplayHandlerInterface;

/**
 * PutSquareController
 *
 * Set a single board square
 *
 * @generated
 */
class PutSquareController extends Controller
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler,
    ) {
    }

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     *
     * @param PutSquareFormRequest $request
     * @return JsonResponse
     */
    public function __invoke(PutSquareFormRequest $request): JsonResponse
    {
        $result = $this->handler->putSquare(
            game_id: $request->route('gameId'),
            row: $request->route('row'),
            column: $request->route('column'),
            move_request: $request->validated(),
        );

        return response()->json($result);
    }
}
