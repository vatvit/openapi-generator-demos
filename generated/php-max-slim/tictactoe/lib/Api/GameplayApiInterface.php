<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Model\Status;

/**
 * GameplayApiInterface
 *
 * API Service interface for GameplayApi operations.
 * Implement this interface in your application to handle API requests.
 *
 * @generated
 */
interface GameplayApiInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getBoard(
        string $game_id,
    );

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getGame(
        string $game_id,
    );

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     *
     * @param string $game_id Unique game identifier
     * @return mixed
     */
    public function getMoves(
        string $game_id,
    );

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

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @param \TictactoeApi\Model\MoveRequest $move_request 
     * @return mixed
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TictactoeApi\Model\MoveRequest $move_request,
    );

}
