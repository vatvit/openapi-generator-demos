<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\GameManagementApiServiceInterface;

/**
 * DeleteGameController
 *
 * Delete a game
 *
 * @generated
 */
class DeleteGameController extends AbstractController
{
    public function __construct(
        private readonly GameManagementApiServiceInterface $handler,
    ) {
    }

    /**
     * Delete a game
     *
     * Deletes a game. Only allowed for game creators or admins.
     */
    public function __invoke(Request $request, string $game_id): JsonResponse
    {
        $result = $this->handler->deleteGame(
            game_id: $game_id,
        );

        return new JsonResponse($result);
    }
}
