<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
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
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface GameplayApiInterface
{

    /**
     * Sets authentication method defaultApiKey
     *
     * @param string|null $value Value of the defaultApiKey authentication method.
     *
     * @return void
     */
    public function setdefaultApiKey(?string $value): void;

    /**
     * Sets authentication method app2AppOauth
     *
     * @param string|null $value Value of the app2AppOauth authentication method.
     *
     * @return void
     */
    public function setapp2AppOauth(?string $value): void;

    /**
     * Sets authentication method bearerHttpAuthentication
     *
     * @param string|null $value Value of the bearerHttpAuthentication authentication method.
     *
     * @return void
     */
    public function setbearerHttpAuthentication(?string $value): void;

    /**
     * Sets authentication method user2AppOauth
     *
     * @param string|null $value Value of the user2AppOauth authentication method.
     *
     * @return void
     */
    public function setuser2AppOauth(?string $value): void;

    /**
     * Operation getBoard
     *
     * Get the game board
     *
     * @param  string $gameId  Unique game identifier (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function getBoard(
        string $gameId,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;

    /**
     * Operation getGame
     *
     * Get game details
     *
     * @param  string $gameId  Unique game identifier (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function getGame(
        string $gameId,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;

    /**
     * Operation getMoves
     *
     * Get move history
     *
     * @param  string $gameId  Unique game identifier (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function getMoves(
        string $gameId,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;

    /**
     * Operation getSquare
     *
     * Get a single board square
     *
     * @param  string $gameId  Unique game identifier (required)
     * @param  int $row  Board row (vertical coordinate) (required)
     * @param  int $column  Board column (horizontal coordinate) (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function getSquare(
        string $gameId,
        int $row,
        int $column,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;

    /**
     * Operation putSquare
     *
     * Set a single board square
     *
     * @param  string $gameId  Unique game identifier (required)
     * @param  int $row  Board row (vertical coordinate) (required)
     * @param  int $column  Board column (horizontal coordinate) (required)
     * @param  MoveRequest $moveRequest   (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function putSquare(
        string $gameId,
        int $row,
        int $column,
        MoveRequest $moveRequest,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;
}
