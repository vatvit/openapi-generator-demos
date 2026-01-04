<?php

declare(strict_types=1);

namespace TictactoeApi\Handler;

use TictactoeApi\Response\GetSquare200Response;
use TictactoeApi\Response\GetSquare400Response;
use TictactoeApi\Response\GetSquare404Response;

/**
 * GetSquareApiHandlerInterface
 *
 * Handler interface for getSquare operation.
 * Implement this to provide business logic.
 *
 * Get a single board square
 *
 * Retrieves the requested square.
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
