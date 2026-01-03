<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class GetSquareController
{
    public function __construct(
        private readonly GameplayApiHandlerInterface $handler
    ) {}

    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     */
    public function __invoke(
        Request $request,
        string $game_id,
        int $row,
        int $column
    ): JsonResponse
    {
        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->getSquare(
            $game_id,
            $row,
            $column
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
