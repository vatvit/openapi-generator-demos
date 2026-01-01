<?php

declare(strict_types=1);

namespace App\Api\TicTacToe;

use TicTacToeApi\Api\StatisticsApiInterface;
use TicTacToeApi\Model\GetLeaderboardTimeframeParameter;
use TicTacToeApi\Model\Leaderboard;
use TicTacToeApi\Model\PlayerStats;
use TicTacToeApi\Model\NotFoundError;

/**
 * Stub handler for Statistics API.
 */
class StatisticsHandler implements StatisticsApiInterface
{
    public function getLeaderboard(
        ?GetLeaderboardTimeframeParameter $timeframe,
        ?int $limit
    ): Leaderboard {
        return new Leaderboard(
            entries: [],
        );
    }

    public function getPlayerStats(string $playerId): PlayerStats|NotFoundError
    {
        return new PlayerStats(
            playerId: $playerId,
            gamesPlayed: 10,
            wins: 5,
            losses: 3,
            draws: 2,
        );
    }
}
