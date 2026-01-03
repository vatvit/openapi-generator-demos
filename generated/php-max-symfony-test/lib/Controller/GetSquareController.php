<?php

declare(strict_types=1);

namespace TictactoeApi\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use TictactoeApi\Api\GameplayApiServiceInterface;

/**
 * GetSquareController
 *
 * Get a single board square
 *
 * @generated
 */
class GetSquareController extends AbstractController
{
    public function __construct(
        private readonly GameplayApiServiceInterface $handler,
    ) {
    }

    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     */
    public function __invoke(Request $request, string $game_id, int $row, int $column): JsonResponse
    {
        $result = $this->handler->getSquare(
            game_id: $game_id,
            row: $row,
            column: $column,
        );

        return new JsonResponse($result);
    }
}
