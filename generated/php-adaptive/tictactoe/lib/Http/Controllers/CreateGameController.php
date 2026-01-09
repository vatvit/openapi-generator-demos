<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Controllers;

use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Http\Requests\CreateGameRequest;
use TicTacToeApi\Model\CreateGameRequest as CreateGameRequestDto;
use Illuminate\Http\JsonResponse;

/**
 * Controller for createGame operation.
 *
 * Create a new game
 *
 * Creates a new TicTacToe game with specified configuration.
 */
final class CreateGameController
{
    public function __construct(
        private readonly GameManagementHandlerInterface $handler
    ) {}

    /**
     * Handle the createGame request.
     *
     * @param CreateGameRequest $request The validated request
     * @return JsonResponse
     */
    public function __invoke(
        CreateGameRequest $request
    ): JsonResponse {
        // Convert validated request data to DTO
        $dto = CreateGameRequestDto::fromArray($request->validated());

        // Delegate to handler (argument order: path params -> query params -> body)
        $response = $this->handler->createGame(
            $dto
        );

        return $response;
    }
}
