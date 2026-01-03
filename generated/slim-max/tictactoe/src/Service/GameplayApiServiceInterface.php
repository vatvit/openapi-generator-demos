<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Service;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Model\Status;
use \GetBoard200Response;
use \GetBoard404Response;
use \GetGame200Response;
use \GetGame404Response;
use \GetMoves200Response;
use \GetMoves404Response;
use \GetSquare200Response;
use \GetSquare400Response;
use \GetSquare404Response;
use \PutSquare200Response;
use \PutSquare400Response;
use \PutSquare404Response;
use \PutSquare409Response;

/**
 * GameplayApiServiceInterface
 *
 * Service interface for business logic implementation.
 * Implement this interface to provide your business logic.
 *
 * Operation: getBoard
 * Operation: getGame
 * Operation: getMoves
 * Operation: getSquare
 * Operation: putSquare
 *
 * @generated
 */
interface GameplayApiServiceInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function getBoard(
        string $game_id
    ): GetBoard200Response|GetBoard404Response;

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function getGame(
        string $game_id
    ): GetGame200Response|GetGame404Response;

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     */
    public function getMoves(
        string $game_id
    ): GetMoves200Response|GetMoves404Response;

    /**
     * Get a single board square
     *
     * Retrieves the requested square.
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column
    ): GetSquare200Response|GetSquare400Response|GetSquare404Response;

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TictactoeApi\Model\\TictactoeApi\Model\MoveRequest $move_request
    ): PutSquare200Response|PutSquare400Response|PutSquare404Response|PutSquare409Response;

}
