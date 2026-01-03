<?php

declare(strict_types=1);

namespace App\Tests\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handler\StatisticsHandler;
use TictactoeApi\Api\Handler\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Response\GetLeaderboard200Response;
use TictactoeApi\Api\Response\GetPlayerStats200Response;
use TictactoeApi\Api\Response\GetPlayerStats404Response;

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

    public function test_get_leaderboard_returns_200_response(): void
    {
        $result = $this->handler->getLeaderboard('weekly', 10);

        $this->assertInstanceOf(GetLeaderboard200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_get_leaderboard_respects_limit(): void
    {
        $result = $this->handler->getLeaderboard('monthly', 2);

        $this->assertInstanceOf(GetLeaderboard200Response::class, $result);
    }

    public function test_get_leaderboard_with_different_timeframes(): void
    {
        $timeframes = ['daily', 'weekly', 'monthly', 'alltime'];

        foreach ($timeframes as $timeframe) {
            $result = $this->handler->getLeaderboard($timeframe, 5);
            $this->assertInstanceOf(GetLeaderboard200Response::class, $result);
        }
    }

    // --- getPlayerStats tests ---

    public function test_get_player_stats_returns_200_for_known_player(): void
    {
        $result = $this->handler->getPlayerStats('player_1');

        $this->assertInstanceOf(GetPlayerStats200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_get_player_stats_returns_404_for_unknown_player(): void
    {
        $result = $this->handler->getPlayerStats('unknown_player');

        $this->assertInstanceOf(GetPlayerStats404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    public function test_get_player_stats_returns_404_for_notfound_prefix(): void
    {
        $result = $this->handler->getPlayerStats('notfound_player');

        $this->assertInstanceOf(GetPlayerStats404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    public function test_all_mock_players_have_stats(): void
    {
        $players = ['player_1', 'player_2', 'player_3'];

        foreach ($players as $playerId) {
            $result = $this->handler->getPlayerStats($playerId);
            $this->assertInstanceOf(GetPlayerStats200Response::class, $result);
        }
    }
}
