<?php

declare(strict_types=1);

namespace App\Handler;

use TictactoeApi\Api\Handler\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Response\GetLeaderboard200Response;
use TictactoeApi\Api\Response\GetPlayerStats200Response;
use TictactoeApi\Api\Response\GetPlayerStats404Response;
use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\LeaderboardEntry;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Player;
use TictactoeApi\Model\PlayerStats;

/**
 * Handler for Statistics API operations.
 */
class StatisticsHandler implements StatisticsApiHandlerInterface
{
    /** @var array<string, PlayerStats> */
    private static array $mockPlayers = [];

    public function __construct()
    {
        // Initialize mock player data if not set
        if (empty(self::$mockPlayers)) {
            self::$mockPlayers = [
                'player_1' => new PlayerStats(
                    playerId: 'player_1',
                    gamesPlayed: 150,
                    wins: 100,
                    losses: 35,
                    draws: 15,
                    winRate: 0.67
                ),
                'player_2' => new PlayerStats(
                    playerId: 'player_2',
                    gamesPlayed: 120,
                    wins: 70,
                    losses: 40,
                    draws: 10,
                    winRate: 0.58
                ),
                'player_3' => new PlayerStats(
                    playerId: 'player_3',
                    gamesPlayed: 80,
                    wins: 40,
                    losses: 30,
                    draws: 10,
                    winRate: 0.50
                ),
            ];
        }
    }

    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null,
    ): GetLeaderboard200Response {
        $effectiveLimit = min($limit ?? 10, 3);

        $entries = [];
        $rank = 1;
        foreach (self::$mockPlayers as $playerId => $stats) {
            if ($rank > $effectiveLimit) {
                break;
            }
            $entries[] = new LeaderboardEntry(
                rank: $rank,
                player: new Player(id: $playerId, username: 'User ' . $rank),
                score: $stats->wins * 10,
                wins: $stats->wins,
                gamesPlayed: $stats->gamesPlayed
            );
            $rank++;
        }

        $leaderboard = new Leaderboard(
            timeframe: $timeframe ?? 'all-time',
            entries: $entries,
            generatedAt: new \DateTime()
        );

        return GetLeaderboard200Response::create($leaderboard);
    }

    public function getPlayerStats(
        string $player_id,
    ): GetPlayerStats200Response|GetPlayerStats404Response {
        // Check for "notfound" or "unknown" prefix patterns
        if (str_starts_with($player_id, 'notfound') || str_starts_with($player_id, 'unknown')) {
            $error = new NotFoundError(
                code: 'PLAYER_NOT_FOUND',
                message: 'Player not found'
            );
            return GetPlayerStats404Response::create($error);
        }

        // Return mock data for known players or default stats for any other ID
        if (isset(self::$mockPlayers[$player_id])) {
            return GetPlayerStats200Response::create(self::$mockPlayers[$player_id]);
        }

        // Default stats for any player ID that doesn't match our patterns
        $stats = new PlayerStats(
            playerId: $player_id,
            gamesPlayed: 100,
            wins: 60,
            losses: 30,
            draws: 10,
            winRate: 0.6
        );

        return GetPlayerStats200Response::create($stats);
    }
}
