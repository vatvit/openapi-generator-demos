<?php

declare(strict_types=1);

namespace TictactoeApi\Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\PlayerStats;

/**
 * StatisticsApiInterface
 *
 * Handler interface for API operations.
 * Implement this interface to provide business logic.
 * Auto-generated from OpenAPI specification.
 */
interface StatisticsApiInterface
{

    /**
     * Sets authentication method bearerHttpAuthentication
     *
     * @param string|null $value Value of the bearerHttpAuthentication authentication method.
     *
     * @return void
     */
    public function setbearerHttpAuthentication(?string $value): void;

    /**
     * Operation getLeaderboard
     *
     * Get leaderboard
     *
     * @param  string $timeframe  Timeframe for leaderboard statistics (optional, default to 'all-time')
     * @param  int $limit  Number of top players to return (optional, default to 10)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function getLeaderboard(
        string $timeframe,
        int $limit,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;

    /**
     * Operation getPlayerStats
     *
     * Get player statistics
     *
     * @param  string $playerId  Unique player identifier (required)
     * @param  int     &$responseCode    The HTTP Response Code
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return array|object|null
     */
    public function getPlayerStats(
        string $playerId,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null;
}
