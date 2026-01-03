<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Status;

/**
 * TicTacApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface TicTacApiInterface
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
}
