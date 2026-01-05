<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;

/**
 * GetSquareApiInterface
 *
 * API Service interface for GetSquareApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * Operation: getSquare
 *
 * @generated
 */
interface GetSquareApiInterface
{
    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @return mixed
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column,
    );

}
