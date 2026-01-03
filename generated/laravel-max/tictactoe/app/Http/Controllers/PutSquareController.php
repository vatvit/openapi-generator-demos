<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\PutSquareApiHandlerInterface;
use TictactoeApi\Api\Http\Requests\PutSquareFormRequest;
use TictactoeApi\Model\MoveRequest;
use Illuminate\Http\JsonResponse;

final class PutSquareController
{
    public function __construct(
        private readonly PutSquareApiHandlerInterface $handler
    ) {}

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     */
    public function __invoke(
        PutSquareFormRequest $request,
        string $game_id,
        int $row,
        int $column
    ): JsonResponse
    {
        // Convert validated data to DTO
        $dto = \TictactoeApi\Model\MoveRequest::fromArray($request->validated());

        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->putSquare(
            $game_id,
            $row,
            $column,
            $dto
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
