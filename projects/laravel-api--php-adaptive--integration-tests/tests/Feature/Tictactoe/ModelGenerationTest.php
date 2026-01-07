<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
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
 * Tests that verify the generated model classes have correct structure.
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
     * Test that Game model has expected properties.
     */
    public function testGameModelHasExpectedProperties(): void
    {
        $reflection = new ReflectionClass(Game::class);

        $expectedProperties = ['id', 'status', 'mode', 'board', 'created_at'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Game should have property '{$property}'"
            );
        }
    }

    /**
     * Test that Game model has optional properties marked as nullable.
     */
    public function testGameModelOptionalPropertiesAreNullable(): void
    {
        $reflection = new ReflectionClass(Game::class);

        $optionalProperties = ['player_x', 'player_o', 'current_turn', 'winner', 'updated_at', 'completed_at'];

        foreach ($optionalProperties as $propName) {
            if ($reflection->hasProperty($propName)) {
                $property = $reflection->getProperty($propName);
                $type = $property->getType();
                $this->assertTrue(
                    $type !== null && $type->allowsNull(),
                    "Property '{$propName}' should be nullable"
                );
            }
        }
    }

    /**
     * Test that all models have fromArray static method.
     */
    public function testAllModelsHaveFromArrayMethod(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'fromArray'),
                "Model {$name} should have fromArray method"
            );

            $reflection = new ReflectionMethod($class, 'fromArray');
            $this->assertTrue($reflection->isStatic(), "fromArray should be static in {$name}");
            $this->assertTrue($reflection->isPublic(), "fromArray should be public in {$name}");
        }
    }

    /**
     * Test that all models have toArray method.
     */
    public function testAllModelsHaveToArrayMethod(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'toArray'),
                "Model {$name} should have toArray method"
            );

            $reflection = new ReflectionMethod($class, 'toArray');
            $this->assertFalse($reflection->isStatic(), "toArray should not be static in {$name}");
            $this->assertTrue($reflection->isPublic(), "toArray should be public in {$name}");
        }
    }

    /**
     * Test that fromArray returns correct return type.
     */
    public function testFromArrayReturnType(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $reflection = new ReflectionMethod($class, 'fromArray');
            $returnType = $reflection->getReturnType();

            $this->assertNotNull($returnType, "fromArray should have return type in {$name}");
            $this->assertSame('self', $returnType->getName(), "fromArray should return self in {$name}");
        }
    }

    /**
     * Test that toArray returns array type.
     */
    public function testToArrayReturnType(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $reflection = new ReflectionMethod($class, 'toArray');
            $returnType = $reflection->getReturnType();

            $this->assertNotNull($returnType, "toArray should have return type in {$name}");
            $this->assertSame('array', $returnType->getName(), "toArray should return array in {$name}");
        }
    }

    /**
     * Test that Player model has expected structure.
     */
    public function testPlayerModelStructure(): void
    {
        $reflection = new ReflectionClass(Player::class);

        $this->assertTrue($reflection->hasProperty('id'), "Player should have 'id' property");
        $this->assertTrue($reflection->hasProperty('username'), "Player should have 'username' property");
    }

    /**
     * Test that Move model has expected structure.
     */
    public function testMoveModelStructure(): void
    {
        $reflection = new ReflectionClass(Move::class);

        $expectedProperties = ['row', 'column', 'mark', 'timestamp'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Move should have property '{$property}'"
            );
        }
    }

    /**
     * Test that Pagination model has expected structure.
     */
    public function testPaginationModelStructure(): void
    {
        $reflection = new ReflectionClass(Pagination::class);

        $expectedProperties = ['page', 'limit', 'total', 'has_next', 'has_previous'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Pagination should have property '{$property}'"
            );
        }
    }

    /**
     * Test constructor has parameters in correct order (required before optional).
     */
    public function testConstructorParameterOrder(): void
    {
        $reflection = new ReflectionClass(Game::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, "Game should have constructor");

        $params = $constructor->getParameters();
        $seenOptional = false;

        foreach ($params as $param) {
            if ($param->isOptional()) {
                $seenOptional = true;
            } else {
                $this->assertFalse(
                    $seenOptional,
                    "Required parameter '{$param->getName()}' should not come after optional parameters"
                );
            }
        }
    }
}
