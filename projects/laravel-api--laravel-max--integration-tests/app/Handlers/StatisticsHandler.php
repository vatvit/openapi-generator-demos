<?php

declare(strict_types=1);

namespace App\Handlers;

use TictactoeApi\Api\Handlers\StatisticsApiHandlerInterface;
use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\LeaderboardEntry;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Player;
use TictactoeApi\Model\PlayerStats;
use TictactoeApi\Api\Http\Resources\GetLeaderboard200Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats200Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats404Resource;

/**
 * Statistics Handler Implementation
 *
 * Implements the StatisticsApiHandler interface with mock statistics data.
 */
class StatisticsHandler implements StatisticsApiHandlerInterface
{
    /**
     * Mock player data
     * @var array<string, array>
     */
    private static array $players = [
        'player_1' => [
            'username' => 'alice',
            'displayName' => 'Alice Champion',
            'wins' => 42,
            'losses' => 18,
            'draws' => 10,
            'score' => 136,
        ],
        'player_2' => [
            'username' => 'bob',
            'displayName' => 'Bob Master',
            'wins' => 38,
            'losses' => 22,
            'draws' => 15,
            'score' => 129,
        ],
        'player_3' => [
            'username' => 'charlie',
            'displayName' => 'Charlie Pro',
            'wins' => 35,
            'losses' => 25,
            'draws' => 12,
            'score' => 117,
        ],
    ];

    /**
     * Get leaderboard
     */
    public function getLeaderboard(
        ?string $timeframe = null,
        ?int $limit = null
    ): GetLeaderboard200Resource {
        $entries = [];
        $rank = 1;

        // Sort players by score descending
        $sortedPlayers = self::$players;
        uasort($sortedPlayers, fn($a, $b) => $b['score'] <=> $a['score']);

        foreach (array_slice($sortedPlayers, 0, $limit, true) as $playerId => $data) {
            $player = new Player(
                id: $playerId,
                username: $data['username'],
                displayName: $data['displayName']
            );

            $entries[] = new LeaderboardEntry(
                rank: $rank++,
                player: $player,
                score: $data['score'],
                wins: $data['wins'],
                gamesPlayed: $data['wins'] + $data['losses'] + $data['draws']
            );
        }

        $leaderboard = new Leaderboard(
            timeframe: $timeframe,
            entries: $entries,
            generatedAt: new \DateTime()
        );

        return new GetLeaderboard200Resource($leaderboard);
    }

    /**
     * Get player statistics
     */
    public function getPlayerStats(
        string $player_id
    ): GetPlayerStats200Resource|GetPlayerStats404Resource {
        // Return 404 for unknown players or IDs starting with 'notfound'
        if (str_starts_with($player_id, 'notfound') || !isset(self::$players[$player_id])) {
            return new GetPlayerStats404Resource(new NotFoundError(
                code: 'PLAYER_NOT_FOUND',
                message: 'Player not found'
            ));
        }

        $data = self::$players[$player_id];
        $gamesPlayed = $data['wins'] + $data['losses'] + $data['draws'];

        $player = new Player(
            id: $player_id,
            username: $data['username'],
            displayName: $data['displayName']
        );

        $playerStats = new PlayerStats(
            playerId: $player_id,
            gamesPlayed: $gamesPlayed,
            wins: $data['wins'],
            losses: $data['losses'],
            draws: $data['draws'],
            player: $player,
            winRate: $gamesPlayed > 0 ? round($data['wins'] / $gamesPlayed, 2) : 0.0,
            currentStreak: 3,
            longestWinStreak: 7
        );

        return new GetPlayerStats200Resource($playerStats);
    }
}
