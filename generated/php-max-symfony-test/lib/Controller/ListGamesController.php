<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\GameManagementApiServiceInterface;

/**
 * ListGamesController
 *
 * List all games
 *
 * @generated
 */
class ListGamesController extends AbstractController
{
    public function __construct(
        private readonly GameManagementApiServiceInterface $handler,
    ) {
    }

    /**
     * List all games
     *
     * Retrieves a paginated list of games with optional filtering.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->listGames(
            page: $request->query->get('page'),
            limit: $request->query->get('limit'),
            status: $request->query->get('status'),
            player_id: $request->query->get('playerId'),
        );

        return new JsonResponse($result);
    }
}
