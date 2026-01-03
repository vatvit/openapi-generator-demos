<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\TicTacApiServiceInterface;

/**
 * GetBoardController
 *
 * Get the game board
 *
 * @generated
 */
class GetBoardController extends AbstractController
{
    public function __construct(
        private readonly TicTacApiServiceInterface $handler,
    ) {
    }

    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function __invoke(Request $request, string $game_id): JsonResponse
    {
        $result = $this->handler->getBoard(
            game_id: $game_id,
        );

        return new JsonResponse($result);
    }
}
