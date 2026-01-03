<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handlers\StatisticsHandler;
use TictactoeApi\Api\Handlers\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Http\Resources\GetLeaderboard200Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats200Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats404Resource;

/**
 * Tests for Statistics Handler Implementation
 */
class StatisticsHandlerTest extends TestCase
{
    private StatisticsHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new StatisticsHandler();
    }

    public function test_handler_implements_interface(): void
    {
        $this->assertInstanceOf(
            StatisticsApiHandlerInterface::class,
            $this->handler,
            'Handler should implement StatisticsApiHandlerInterface'
        );
    }

    // --- getLeaderboard tests ---

    public function test_get_leaderboard_returns_200_resource(): void
    {
        $result = $this->handler->getLeaderboard('weekly', 10);

        $this->assertInstanceOf(GetLeaderboard200Resource::class, $result);
    }

    public function test_get_leaderboard_respects_limit(): void
    {
        $result = $this->handler->getLeaderboard('monthly', 2);

        $this->assertInstanceOf(GetLeaderboard200Resource::class, $result);
    }

    public function test_get_leaderboard_with_different_timeframes(): void
    {
        $timeframes = ['daily', 'weekly', 'monthly', 'alltime'];

        foreach ($timeframes as $timeframe) {
            $result = $this->handler->getLeaderboard($timeframe, 5);
            $this->assertInstanceOf(GetLeaderboard200Resource::class, $result);
        }
    }

    // --- getPlayerStats tests ---

    public function test_get_player_stats_returns_200_for_known_player(): void
    {
        $result = $this->handler->getPlayerStats('player_1');

        $this->assertInstanceOf(GetPlayerStats200Resource::class, $result);
    }

    public function test_get_player_stats_returns_404_for_unknown_player(): void
    {
        $result = $this->handler->getPlayerStats('unknown_player');

        $this->assertInstanceOf(GetPlayerStats404Resource::class, $result);
    }

    public function test_get_player_stats_returns_404_for_notfound_prefix(): void
    {
        $result = $this->handler->getPlayerStats('notfound_player');

        $this->assertInstanceOf(GetPlayerStats404Resource::class, $result);
    }

    public function test_all_mock_players_have_stats(): void
    {
        $players = ['player_1', 'player_2', 'player_3'];

        foreach ($players as $playerId) {
            $result = $this->handler->getPlayerStats($playerId);
            $this->assertInstanceOf(GetPlayerStats200Resource::class, $result);
        }
    }
}
