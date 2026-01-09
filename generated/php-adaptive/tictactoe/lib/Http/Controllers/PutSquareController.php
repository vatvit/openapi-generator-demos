<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Http\Requests\PutSquareRequest;
use TicTacToeApi\Model\MoveRequest as MoveRequestDto;
use Illuminate\Http\JsonResponse;

/**
 * Controller for putSquare operation.
 *
 * Set a single board square
 *
 * Places a mark on the board and retrieves the whole board and the winner (if any).
 */
final class PutSquareController
{
    public function __construct(
        private readonly GameplayHandlerInterface $handler
    ) {}

    /**
     * Handle the putSquare request.
     *
     * @param PutSquareRequest $request The validated request
     * @param string $game_id Path parameter: Unique game identifier
     * @param int $row Path parameter: Board row (vertical coordinate)
     * @param int $column Path parameter: Board column (horizontal coordinate)
     * @return JsonResponse
     */
    public function __invoke(
        PutSquareRequest $request,
        string $game_id,
        int $row,
        int $column
    ): JsonResponse {
        // Convert validated request data to DTO
        $dto = MoveRequestDto::fromArray($request->validated());

        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->putSquare(
            $game_id,
            $row,
            $column,
            $dto
        );

        return $response;
    }
}
