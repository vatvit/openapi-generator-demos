<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Api\Response\GetSquare200Response;
use TictactoeApi\Api\Response\GetSquare400Response;
use TictactoeApi\Api\Response\GetSquare404Response;

/**
 * GetSquareApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getSquare
 *
 * @generated
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
        int $column,
    ): GetSquare200Response|GetSquare400Response|GetSquare404Response;

}
