<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\GameplayApiServiceInterface;

/**
 * GetGameController
 *
 * Get game details
 *
 * @generated
 */
class GetGameController extends AbstractController
{
    public function __construct(
        private readonly GameplayApiServiceInterface $handler,
    ) {
    }

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function __invoke(Request $request, string $game_id): JsonResponse
    {
        $result = $this->handler->getGame(
            game_id: $game_id,
        );

        return new JsonResponse($result);
    }
}
