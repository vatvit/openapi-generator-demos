<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\StatisticsApiServiceInterface;

/**
 * GetLeaderboardController
 *
 * Get leaderboard
 *
 * @generated
 */
class GetLeaderboardController extends AbstractController
{
    public function __construct(
        private readonly StatisticsApiServiceInterface $handler,
    ) {
    }

    /**
     * Get leaderboard
     *
     * Retrieves the global leaderboard with top players.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->handler->getLeaderboard(
            timeframe: $request->query->get('timeframe'),
            limit: $request->query->get('limit'),
        );

        return new JsonResponse($result);
    }
}
