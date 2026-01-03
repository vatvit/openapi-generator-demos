<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use TictactoeApi\Request\CreateGameFormRequest;
use TictactoeApi\Handler\GameManagementHandlerInterface;

/**
 * CreateGameController
 *
 * Create a new game
 *
 * @generated
 */
class CreateGameController extends Controller
{
    public function __construct(
        private readonly GameManagementHandlerInterface $handler,
    ) {
    }

    /**
     * Create a new game
     *
     * Creates a new TicTacToe game with specified configuration.
     *
     * @param CreateGameFormRequest $request
     * @return JsonResponse
     */
    public function __invoke(CreateGameFormRequest $request): JsonResponse
    {
        $result = $this->handler->createGame(
            create_game_request: $request->validated(),
        );

        return response()->json($result);
    }
}
