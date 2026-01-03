<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\GameplayApiServiceInterface;

/**
 * GetMovesController
 *
 * Get move history
 *
 * @generated
 */
class GetMovesController extends AbstractController
{
    public function __construct(
        private readonly GameplayApiServiceInterface $handler,
    ) {
    }

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     */
    public function __invoke(Request $request, string $game_id): JsonResponse
    {
        $result = $this->handler->getMoves(
            game_id: $game_id,
        );

        return new JsonResponse($result);
    }
}
