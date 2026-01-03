<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\TicTacApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class GetBoardController
{
    public function __construct(
        private readonly TicTacApiHandlerInterface $handler
    ) {}

    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function __invoke(
        Request $request,
        string $game_id
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->getBoard(
            $game_id
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
