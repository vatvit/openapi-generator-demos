<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TicTacToeApi\Model\Game;
use TicTacToeApi\Model\Player;
use TicTacToeApi\Model\Move;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\GameListResponse;
use TicTacToeApi\Model\Leaderboard;
use TicTacToeApi\Model\LeaderboardEntry;
use TicTacToeApi\Model\Pagination;
use TicTacToeApi\Model\PlayerStats;
use TicTacToeApi\Model\MoveRequest;
use TicTacToeApi\Model\MoveHistory;
use TicTacToeApi\Model\SquareResponse;
use TicTacToeApi\Model\Error;
use TicTacToeApi\Model\GameMode;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\Mark;

/**
 * Tests that verify the generated model classes behave correctly.
 */
class ModelGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Models to test for existence
     */
    private array $expectedModels = [
        'Game' => Game::class,
        'Player' => Player::class,
        'Move' => Move::class,
        'CreateGameRequest' => CreateGameRequest::class,
        'GameListResponse' => GameListResponse::class,
        'Leaderboard' => Leaderboard::class,
        'LeaderboardEntry' => LeaderboardEntry::class,
        'Pagination' => Pagination::class,
        'PlayerStats' => PlayerStats::class,
        'MoveRequest' => MoveRequest::class,
        'MoveHistory' => MoveHistory::class,
        'SquareResponse' => SquareResponse::class,
        'Error' => Error::class,
    ];

    /**
     * Test that all expected model classes exist.
     */
    public function testAllModelClassesExist(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Model class {$name} should exist"
            );
        }
    }

    /**
     * Test that Game model can be created with expected properties.
     */
    public function testGameModelCanBeCreatedWithProperties(): void
    {
        $game = Game::fromArray([
            'id' => 'game-123',
            'status' => GameStatus::IN_PROGRESS,
            'mode' => GameMode::PVP,
            'board' => [['X', null, null], [null, 'O', null], [null, null, null]],
            'createdAt' => '2024-01-01T00:00:00Z',
        ]);

        $this->assertInstanceOf(Game::class, $game);
        $array = $game->toArray();
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('mode', $array);
        $this->assertArrayHasKey('board', $array);
        $this->assertArrayHasKey('createdAt', $array);
    }

    /**
     * Test that Game model accepts null for optional properties.
     */
    public function testGameModelAcceptsNullForOptionalProperties(): void
    {
        $game = Game::fromArray([
            'id' => 'game-123',
            'status' => GameStatus::PENDING,
            'mode' => GameMode::PVP,
            'board' => [['', '', ''], ['', '', ''], ['', '', '']],
            'createdAt' => '2024-01-01T00:00:00Z',
            'playerX' => null,
            'playerO' => null,
            'currentTurn' => null,
            'winner' => null,
            'updatedAt' => null,
            'completedAt' => null,
        ]);

        $this->assertInstanceOf(Game::class, $game);
        $array = $game->toArray();
        // Optional properties should be in array (may be null)
        $this->assertArrayHasKey('playerX', $array);
    }

    /**
     * Test that all models have fromArray method that returns instance.
     */
    public function testAllModelsFromArrayReturnsInstance(): void
    {
        $testData = $this->getTestDataForModels();

        foreach ($this->expectedModels as $name => $class) {
            $data = $testData[$name] ?? [];
            $instance = $class::fromArray($data);
            $this->assertInstanceOf(
                $class,
                $instance,
                "{$name}::fromArray() should return instance of {$name}"
            );
        }
    }

    /**
     * Test that all models have toArray method that returns array.
     */
    public function testAllModelsToArrayReturnsArray(): void
    {
        $testData = $this->getTestDataForModels();

        foreach ($this->expectedModels as $name => $class) {
            $data = $testData[$name] ?? [];
            $instance = $class::fromArray($data);
            $array = $instance->toArray();
            $this->assertIsArray(
                $array,
                "{$name}::toArray() should return array"
            );
        }
    }

    /**
     * Test that fromArray -> toArray roundtrip preserves data.
     */
    public function testFromArrayToArrayRoundtrip(): void
    {
        $originalData = [
            'id' => 'player-456',
            'username' => 'testuser',
        ];

        $player = Player::fromArray($originalData);
        $resultData = $player->toArray();

        $this->assertSame($originalData['id'], $resultData['id']);
        $this->assertSame($originalData['username'], $resultData['username']);
    }

    /**
     * Test that Player model has expected data.
     */
    public function testPlayerModelBehavior(): void
    {
        $player = Player::fromArray([
            'id' => 'player-123',
            'username' => 'john_doe',
        ]);

        $array = $player->toArray();
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('username', $array);
        $this->assertSame('player-123', $array['id']);
        $this->assertSame('john_doe', $array['username']);
    }

    /**
     * Test that Move model has expected data.
     */
    public function testMoveModelBehavior(): void
    {
        $move = Move::fromArray([
            'moveNumber' => 1,
            'playerId' => 'player-123',
            'row' => 1,
            'column' => 2,
            'mark' => 'X',
            'timestamp' => '2024-01-01T00:00:00Z',
        ]);

        $array = $move->toArray();
        $this->assertArrayHasKey('row', $array);
        $this->assertArrayHasKey('column', $array);
        $this->assertArrayHasKey('mark', $array);
        $this->assertArrayHasKey('timestamp', $array);
        $this->assertArrayHasKey('moveNumber', $array);
        $this->assertArrayHasKey('playerId', $array);
    }

    /**
     * Test that Pagination model has expected data.
     */
    public function testPaginationModelBehavior(): void
    {
        $pagination = Pagination::fromArray([
            'page' => 1,
            'limit' => 10,
            'total' => 100,
            'hasNext' => true,
            'hasPrevious' => false,
        ]);

        $array = $pagination->toArray();
        $this->assertArrayHasKey('page', $array);
        $this->assertArrayHasKey('limit', $array);
        $this->assertArrayHasKey('total', $array);
        $this->assertArrayHasKey('hasNext', $array);
        $this->assertArrayHasKey('hasPrevious', $array);
    }

    /**
     * Test that Game model constructor accepts arguments correctly.
     */
    public function testGameModelConstructorWorks(): void
    {
        // Test that we can create via fromArray (which uses constructor internally)
        $game = Game::fromArray([
            'id' => 'test-game',
            'status' => GameStatus::PENDING,
            'mode' => GameMode::PVP,
            'board' => [['', '', ''], ['', '', ''], ['', '', '']],
            'createdAt' => '2024-01-01T00:00:00Z',
        ]);

        $this->assertInstanceOf(Game::class, $game);

        // Test with optional parameters too
        $player = Player::fromArray(['id' => 'p1', 'username' => 'user1']);
        $gameWithOptional = Game::fromArray([
            'id' => 'test-game-2',
            'status' => GameStatus::IN_PROGRESS,
            'mode' => GameMode::AI_EASY,
            'board' => [['X', '', ''], ['', 'O', ''], ['', '', '']],
            'createdAt' => '2024-01-01T00:00:00Z',
            'playerX' => $player,
            'currentTurn' => Mark::X,
        ]);

        $this->assertInstanceOf(Game::class, $gameWithOptional);
    }

    /**
     * Provide test data for each model class.
     *
     * @return array<string, array<string, mixed>>
     */
    private function getTestDataForModels(): array
    {
        return [
            'Game' => [
                'id' => 'game-123',
                'status' => GameStatus::PENDING,
                'mode' => GameMode::PVP,
                'board' => [['', '', ''], ['', '', ''], ['', '', '']],
                'createdAt' => '2024-01-01T00:00:00Z',
            ],
            'Player' => [
                'id' => 'player-123',
                'username' => 'testuser',
            ],
            'Move' => [
                'moveNumber' => 1,
                'playerId' => 'player-123',
                'row' => 0,
                'column' => 0,
                'mark' => 'X',
                'timestamp' => '2024-01-01T00:00:00Z',
            ],
            'CreateGameRequest' => [
                'mode' => GameMode::PVP,
            ],
            'GameListResponse' => [
                'games' => [],
                'pagination' => Pagination::fromArray([
                    'page' => 1,
                    'limit' => 10,
                    'total' => 0,
                    'hasNext' => false,
                    'hasPrevious' => false,
                ]),
            ],
            'Leaderboard' => [
                'entries' => [],
                'timeframe' => 'all_time',
                'generatedAt' => '2024-01-01T00:00:00Z',
            ],
            'LeaderboardEntry' => [
                'player' => Player::fromArray(['id' => 'p1', 'username' => 'user1']),
                'wins' => 10,
                'losses' => 5,
                'draws' => 2,
                'rank' => 1,
                'score' => 100,
            ],
            'Pagination' => [
                'page' => 1,
                'limit' => 10,
                'total' => 100,
                'hasNext' => true,
                'hasPrevious' => false,
            ],
            'PlayerStats' => [
                'playerId' => 'p1',
                'player' => Player::fromArray(['id' => 'p1', 'username' => 'user1']),
                'gamesPlayed' => 20,
                'wins' => 10,
                'losses' => 7,
                'draws' => 3,
                'winRate' => 0.5,
            ],
            'MoveRequest' => [
                'mark' => 'X',
            ],
            'MoveHistory' => [
                'gameId' => 'game-123',
                'moves' => [],
            ],
            'SquareResponse' => [
                'row' => 0,
                'column' => 0,
                'mark' => Mark::X,
            ],
            'Error' => [
                'message' => 'An error occurred',
                'code' => 'ERR001',
            ],
        ];
    }
}
