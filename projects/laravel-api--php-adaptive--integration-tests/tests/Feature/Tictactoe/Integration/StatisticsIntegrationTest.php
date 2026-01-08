<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe\Integration;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;
use App\Handlers\Tictactoe\StatisticsHandler;

/**
 * Integration tests for TicTacToe Statistics operations.
 *
 * Tests the handler implementations with real model DTOs.
 */
class StatisticsIntegrationTest extends TestCase
{
    private StatisticsHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new StatisticsHandler();
    }

    /**
     * Test getLeaderboard returns 200 with leaderboard data.
     */
    public function testGetLeaderboardReturns200WithLeaderboardData(): void
    {
        $response = $this->handler->getLeaderboard();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('entries', $data);
        $this->assertArrayHasKey('timeframe', $data);
        $this->assertArrayHasKey('generatedAt', $data);
    }

    /**
     * Test getLeaderboard returns entries with required fields.
     */
    public function testGetLeaderboardReturnsEntriesWithRequiredFields(): void
    {
        $response = $this->handler->getLeaderboard();

        $data = json_decode($response->getContent(), true);
        $this->assertNotEmpty($data['entries']);

        $entry = $data['entries'][0];
        $this->assertArrayHasKey('player', $entry);
        $this->assertArrayHasKey('rank', $entry);
        $this->assertArrayHasKey('score', $entry);
        $this->assertArrayHasKey('wins', $entry);
        $this->assertArrayHasKey('losses', $entry);
        $this->assertArrayHasKey('draws', $entry);
    }

    /**
     * Test getLeaderboard entries are ranked in order.
     */
    public function testGetLeaderboardEntriesAreRankedInOrder(): void
    {
        $response = $this->handler->getLeaderboard();

        $data = json_decode($response->getContent(), true);

        $lastRank = 0;
        foreach ($data['entries'] as $entry) {
            $this->assertGreaterThan($lastRank, $entry['rank']);
            $lastRank = $entry['rank'];
        }
    }

    /**
     * Test getLeaderboard scores are in descending order.
     */
    public function testGetLeaderboardScoresInDescendingOrder(): void
    {
        $response = $this->handler->getLeaderboard();

        $data = json_decode($response->getContent(), true);

        $lastScore = PHP_INT_MAX;
        foreach ($data['entries'] as $entry) {
            $this->assertLessThanOrEqual($lastScore, $entry['score']);
            $lastScore = $entry['score'];
        }
    }

    /**
     * Test getLeaderboard player has id and username.
     */
    public function testGetLeaderboardPlayerHasIdAndUsername(): void
    {
        $response = $this->handler->getLeaderboard();

        $data = json_decode($response->getContent(), true);
        $player = $data['entries'][0]['player'];

        $this->assertArrayHasKey('id', $player);
        $this->assertArrayHasKey('username', $player);
    }

    /**
     * Test getLeaderboard defaults to all_time timeframe.
     */
    public function testGetLeaderboardDefaultsToAllTimeTimeframe(): void
    {
        $response = $this->handler->getLeaderboard();

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('all_time', $data['timeframe']);
    }

    /**
     * Test getLeaderboard with custom timeframe.
     */
    public function testGetLeaderboardWithCustomTimeframe(): void
    {
        $response = $this->handler->getLeaderboard('weekly');

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('weekly', $data['timeframe']);
    }

    /**
     * Test getLeaderboard generatedAt is valid ISO 8601 date.
     */
    public function testGetLeaderboardGeneratedAtIsValidDate(): void
    {
        $response = $this->handler->getLeaderboard();

        $data = json_decode($response->getContent(), true);
        $timestamp = strtotime($data['generatedAt']);
        $this->assertNotFalse($timestamp);
    }

    /**
     * Test getPlayerStats returns 200 with player stats.
     */
    public function testGetPlayerStatsReturns200WithPlayerStats(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('playerId', $data);
        $this->assertArrayHasKey('player', $data);
        $this->assertArrayHasKey('gamesPlayed', $data);
        $this->assertArrayHasKey('wins', $data);
        $this->assertArrayHasKey('losses', $data);
        $this->assertArrayHasKey('draws', $data);
    }

    /**
     * Test getPlayerStats returns correct player id.
     */
    public function testGetPlayerStatsReturnsCorrectPlayerId(): void
    {
        $response = $this->handler->getPlayerStats('player-456');

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('player-456', $data['playerId']);
        $this->assertEquals('player-456', $data['player']['id']);
    }

    /**
     * Test getPlayerStats player has id and username.
     */
    public function testGetPlayerStatsPlayerHasIdAndUsername(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data['player']);
        $this->assertArrayHasKey('username', $data['player']);
    }

    /**
     * Test getPlayerStats includes win rate.
     */
    public function testGetPlayerStatsIncludesWinRate(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('winRate', $data);
        $this->assertIsFloat($data['winRate']);
        $this->assertGreaterThanOrEqual(0, $data['winRate']);
        $this->assertLessThanOrEqual(1, $data['winRate']);
    }

    /**
     * Test getPlayerStats includes streak data.
     */
    public function testGetPlayerStatsIncludesStreakData(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('currentStreak', $data);
        $this->assertArrayHasKey('longestWinStreak', $data);
    }

    /**
     * Test getPlayerStats games played equals wins + losses + draws.
     */
    public function testGetPlayerStatsGamesPlayedEqualsWinsLossesDraws(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $expectedTotal = $data['wins'] + $data['losses'] + $data['draws'];
        $this->assertEquals($expectedTotal, $data['gamesPlayed']);
    }

    /**
     * Test getPlayerStats win rate calculation is correct.
     */
    public function testGetPlayerStatsWinRateCalculationIsCorrect(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $expectedWinRate = $data['wins'] / $data['gamesPlayed'];
        $this->assertEqualsWithDelta($expectedWinRate, $data['winRate'], 0.001);
    }

    /**
     * Test getPlayerStats current streak is non-negative.
     */
    public function testGetPlayerStatsCurrentStreakIsNonNegative(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThanOrEqual(0, $data['currentStreak']);
    }

    /**
     * Test getPlayerStats longest win streak >= current streak.
     */
    public function testGetPlayerStatsLongestWinStreakGreaterThanOrEqualToCurrentStreak(): void
    {
        $response = $this->handler->getPlayerStats('player-123');

        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThanOrEqual($data['currentStreak'], $data['longestWinStreak']);
    }
}
