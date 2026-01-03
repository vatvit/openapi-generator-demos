<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Controllers;

use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Http\Requests\CreateGameFormRequest;
use TictactoeApi\Model\CreateGameRequest;
use Illuminate\Http\JsonResponse;

final class CreateGameController
{
    public function __construct(
        private readonly GameManagementApiHandlerInterface $handler
    ) {}

    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     */
    public function __invoke(
        CreateGameFormRequest $request
    ): JsonResponse
    {
        // Convert validated data to DTO
        $dto = \TictactoeApi\Model\CreateGameRequest::fromArray($request->validated());

        // Delegate to Handler (arguments match HandlerInterface order: path → query → body)
        $resource = $this->handler->createGame(
            $dto
        );

        // Resource enforces HTTP code and headers
        return $resource->response($request);
    }
}
