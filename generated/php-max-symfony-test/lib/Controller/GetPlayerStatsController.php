<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\StatisticsApiServiceInterface;

/**
 * GetPlayerStatsController
 *
 * Get player statistics
 *
 * @generated
 */
class GetPlayerStatsController extends AbstractController
{
    public function __construct(
        private readonly StatisticsApiServiceInterface $handler,
    ) {
    }

    /**
     * Get player statistics
     *
     * Retrieves comprehensive statistics for a player.
     */
    public function __invoke(Request $request, string $player_id): JsonResponse
    {
        $result = $this->handler->getPlayerStats(
            player_id: $player_id,
        );

        return new JsonResponse($result);
    }
}
