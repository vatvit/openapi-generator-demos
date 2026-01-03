<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handlers;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Api\Http\Resources\GetSquare200Resource;
use TictactoeApi\Api\Http\Resources\GetSquare400Resource;
use TictactoeApi\Api\Http\Resources\GetSquare404Resource;

/**
 * GetSquareApiHandler
 *
 * Handler interface - implement this to provide business logic
 * Returns Resources with compile-time type safety via union types
 *
 * Operation: getSquare
 */
interface GetSquareApiHandlerInterface
{
    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column
    ): GetSquare200Resource|GetSquare400Resource|GetSquare404Resource;

}
