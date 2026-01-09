<?php

declare(strict_types=1);

namespace TicTacToeApi\Api;

use Illuminate\Http\JsonResponse;

/**
 * GameplayHandlerInterface
 *
 * Handler interface for Gameplay API operations.
 * Implement this interface to provide business logic.
 */
interface GameplayHandlerInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     *
     * @param string $game_id Unique game identifier
     * @return JsonResponse
     */
    public function getBoard(
        string $game_id
    ): JsonResponse;

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     *
     * @param string $game_id Unique game identifier
     * @return JsonResponse
     */
    public function getGame(
        string $game_id
    ): JsonResponse;

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     *
     * @param string $game_id Unique game identifier
     * @return JsonResponse
     */
    public function getMoves(
        string $game_id
    ): JsonResponse;

    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @return JsonResponse
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column
    ): JsonResponse;

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     *
     * @param string $game_id Unique game identifier
     * @param int $row Board row (vertical coordinate)
     * @param int $column Board column (horizontal coordinate)
     * @param \TicTacToeApi\Model\MoveRequest $move_request Request body DTO
     * @return JsonResponse
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TicTacToeApi\Model\MoveRequest $move_request
    ): JsonResponse;

}
