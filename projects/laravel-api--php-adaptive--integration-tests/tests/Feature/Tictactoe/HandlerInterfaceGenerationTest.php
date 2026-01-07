<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Http\JsonResponse;
use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Api\TicTacHandlerInterface;

/**
 * Tests that verify the generated handler interfaces have correct structure.
 */
class HandlerInterfaceGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Handler interfaces to test
     */
    private array $expectedInterfaces = [
        'GameManagement' => GameManagementHandlerInterface::class,
        'Gameplay' => GameplayHandlerInterface::class,
        'Statistics' => StatisticsHandlerInterface::class,
        'TicTac' => TicTacHandlerInterface::class,
    ];

    /**
     * Test that all expected handler interfaces exist.
     */
    public function testAllHandlerInterfacesExist(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $this->assertTrue(
                interface_exists($interface),
                "Handler interface {$name} should exist"
            );
        }
    }

    /**
     * Test that all handler interfaces are actual interfaces (not classes).
     */
    public function testAllAreInterfaces(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $reflection = new ReflectionClass($interface);
            $this->assertTrue(
                $reflection->isInterface(),
                "{$name} should be an interface"
            );
        }
    }

    /**
     * Test GameManagementHandlerInterface has expected methods.
     */
    public function testGameManagementHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['createGame', 'deleteGame', 'getGame', 'listGames'];
        $reflection = new ReflectionClass(GameManagementHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "GameManagementHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test GameplayHandlerInterface has expected methods.
     */
    public function testGameplayHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['getBoard', 'getGame', 'getMoves', 'getSquare', 'putSquare'];
        $reflection = new ReflectionClass(GameplayHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "GameplayHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test StatisticsHandlerInterface has expected methods.
     */
    public function testStatisticsHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['getLeaderboard', 'getPlayerStats'];
        $reflection = new ReflectionClass(StatisticsHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "StatisticsHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test TicTacHandlerInterface has expected methods.
     */
    public function testTicTacHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['getBoard'];
        $reflection = new ReflectionClass(TicTacHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "TicTacHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test that all handler methods return JsonResponse.
     */
    public function testAllMethodsReturnJsonResponse(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $reflection = new ReflectionClass($interface);
            foreach ($reflection->getMethods() as $method) {
                $returnType = $method->getReturnType();
                $this->assertNotNull(
                    $returnType,
                    "Method {$name}::{$method->getName()} should have a return type"
                );
                $this->assertSame(
                    JsonResponse::class,
                    $returnType->getName(),
                    "Method {$name}::{$method->getName()} should return JsonResponse"
                );
            }
        }
    }

    /**
     * Test createGame method has correct parameters.
     */
    public function testCreateGameMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            GameManagementHandlerInterface::class,
            'createGame'
        );
        $params = $reflection->getParameters();

        $this->assertCount(1, $params, "createGame should have 1 parameter");
        $this->assertSame('create_game_request', $params[0]->getName());
        $this->assertSame(
            'TicTacToeApi\Model\CreateGameRequest',
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test listGames method has correct parameters.
     */
    public function testListGamesMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            GameManagementHandlerInterface::class,
            'listGames'
        );
        $params = $reflection->getParameters();

        $this->assertCount(4, $params, "listGames should have 4 parameters");

        // All params should be optional (nullable with defaults)
        foreach ($params as $param) {
            $this->assertTrue(
                $param->isOptional(),
                "Parameter {$param->getName()} should be optional"
            );
        }
    }

    /**
     * Test getGame method has correct parameters.
     */
    public function testGetGameMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            GameManagementHandlerInterface::class,
            'getGame'
        );
        $params = $reflection->getParameters();

        $this->assertCount(1, $params, "getGame should have 1 parameter");
        $this->assertSame('game_id', $params[0]->getName());
        $this->assertSame('string', $params[0]->getType()->getName());
        $this->assertFalse($params[0]->isOptional(), "game_id should be required");
    }

    /**
     * Test putSquare method has correct parameters.
     */
    public function testPutSquareMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            GameplayHandlerInterface::class,
            'putSquare'
        );
        $params = $reflection->getParameters();

        $this->assertCount(4, $params, "putSquare should have 4 parameters");

        // Check parameter names
        $this->assertSame('game_id', $params[0]->getName());
        $this->assertSame('row', $params[1]->getName());
        $this->assertSame('column', $params[2]->getName());
        $this->assertSame('move_request', $params[3]->getName());

        // Check parameter types
        $this->assertSame('string', $params[0]->getType()->getName());
        $this->assertSame('int', $params[1]->getType()->getName());
        $this->assertSame('int', $params[2]->getType()->getName());
        $this->assertSame(
            'TicTacToeApi\Model\MoveRequest',
            $params[3]->getType()->getName()
        );
    }

    /**
     * Test getPlayerStats method has correct parameters.
     */
    public function testGetPlayerStatsMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            StatisticsHandlerInterface::class,
            'getPlayerStats'
        );
        $params = $reflection->getParameters();

        $this->assertCount(1, $params, "getPlayerStats should have 1 parameter");
        $this->assertSame('player_id', $params[0]->getName());
        $this->assertSame('string', $params[0]->getType()->getName());
    }

    /**
     * Test getLeaderboard method has correct parameters.
     */
    public function testGetLeaderboardMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            StatisticsHandlerInterface::class,
            'getLeaderboard'
        );
        $params = $reflection->getParameters();

        $this->assertCount(2, $params, "getLeaderboard should have 2 parameters");
        $this->assertSame('timeframe', $params[0]->getName());
        $this->assertSame('limit', $params[1]->getName());

        // Both should be optional
        $this->assertTrue($params[0]->isOptional());
        $this->assertTrue($params[1]->isOptional());
    }

    /**
     * Test that all methods are public.
     */
    public function testAllMethodsArePublic(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $reflection = new ReflectionClass($interface);
            foreach ($reflection->getMethods() as $method) {
                $this->assertTrue(
                    $method->isPublic(),
                    "Method {$name}::{$method->getName()} should be public"
                );
            }
        }
    }
}
