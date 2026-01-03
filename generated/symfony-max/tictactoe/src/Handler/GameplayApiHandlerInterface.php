<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Handler;

use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Model\Status;
use TictactoeApi\Api\Response\GetBoard200Response;
use TictactoeApi\Api\Response\GetBoard404Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\GetMoves200Response;
use TictactoeApi\Api\Response\GetMoves404Response;
use TictactoeApi\Api\Response\GetSquare200Response;
use TictactoeApi\Api\Response\GetSquare400Response;
use TictactoeApi\Api\Response\GetSquare404Response;
use TictactoeApi\Api\Response\PutSquare200Response;
use TictactoeApi\Api\Response\PutSquare400Response;
use TictactoeApi\Api\Response\PutSquare404Response;
use TictactoeApi\Api\Response\PutSquare409Response;

/**
 * GameplayApiHandler
 *
 * Handler interface - implement this to provide business logic.
 * Returns Response DTOs with compile-time type safety via union types.
 *
 * Operation: getBoard
 * Operation: getGame
 * Operation: getMoves
 * Operation: getSquare
 * Operation: putSquare
 *
 * @generated
 */
interface GameplayHandlerInterface
{
    /**
     * Get the game board
     *
     * Retrieves the current state of the board and the winner.
     */
    public function getBoard(
        string $game_id,
    ): GetBoard200Response|GetBoard404Response;

    /**
     * Get game details
     *
     * Retrieves detailed information about a specific game.
     */
    public function getGame(
        string $game_id,
    ): GetGame200Response|GetGame404Response;

    /**
     * Get move history
     *
     * Retrieves the complete move history for a game.
     */
    public function getMoves(
        string $game_id,
    ): GetMoves200Response|GetMoves404Response;

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

    /**
     * Set a single board square
     *
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        \TictactoeApi\Model\MoveRequest $move_request
    ): PutSquare200Response|PutSquare400Response|PutSquare404Response|PutSquare409Response;

}
