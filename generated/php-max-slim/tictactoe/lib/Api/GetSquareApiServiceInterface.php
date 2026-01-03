<?php

declare(strict_types=1);

namespace TicTacToe\Api;

use TicTacToe\Model\BadRequestError;
use TicTacToe\Model\NotFoundError;
use TicTacToe\Model\SquareResponse;

/**
 * GetSquareApiServiceInterface
 *
 * Service interface for GetSquareApi operations.
 * Implement this interface in your application to handle business logic.
 *
 * @generated
 */
interface GetSquareApiServiceInterface
{
    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @return mixed Response data
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column,
    ): mixed;

}
