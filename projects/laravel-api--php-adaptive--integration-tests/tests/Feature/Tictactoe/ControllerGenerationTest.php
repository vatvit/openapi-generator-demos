<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Http\JsonResponse;
use TicTacToeApi\Http\Controllers\CreateGameController;
use TicTacToeApi\Http\Controllers\DeleteGameController;
use TicTacToeApi\Http\Controllers\GetBoardController;
use TicTacToeApi\Http\Controllers\GetGameController;
use TicTacToeApi\Http\Controllers\GetLeaderboardController;
use TicTacToeApi\Http\Controllers\GetMovesController;
use TicTacToeApi\Http\Controllers\GetPlayerStatsController;
use TicTacToeApi\Http\Controllers\GetSquareController;
use TicTacToeApi\Http\Controllers\ListGamesController;
use TicTacToeApi\Http\Controllers\PutSquareController;
use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Http\Requests\CreateGameRequest;
use TicTacToeApi\Http\Requests\GetGameRequest;

/**
 * Tests that verify the generated controller classes have correct structure.
 */
class ControllerGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Controllers to test
     */
    private array $expectedControllers = [
        'CreateGame' => CreateGameController::class,
        'DeleteGame' => DeleteGameController::class,
        'GetBoard' => GetBoardController::class,
        'GetGame' => GetGameController::class,
        'GetLeaderboard' => GetLeaderboardController::class,
        'GetMoves' => GetMovesController::class,
        'GetPlayerStats' => GetPlayerStatsController::class,
        'GetSquare' => GetSquareController::class,
        'ListGames' => ListGamesController::class,
        'PutSquare' => PutSquareController::class,
    ];

    /**
     * Test that all expected controller classes exist.
     */
    public function testAllControllersExist(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Controller {$name} should exist"
            );
        }
    }

    /**
     * Test that all controllers are final.
     */
    public function testAllControllersAreFinal(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isFinal(),
                "{$name}Controller should be final"
            );
        }
    }

    /**
     * Test that all controllers have __invoke method.
     */
    public function testAllControllersHaveInvokeMethod(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $this->assertTrue(
                method_exists($class, '__invoke'),
                "{$name}Controller should have __invoke method"
            );
        }
    }

    /**
     * Test that all controllers have constructor.
     */
    public function testAllControllersHaveConstructor(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertNotNull(
                $reflection->getConstructor(),
                "{$name}Controller should have constructor"
            );
        }
    }

    /**
     * Test that all __invoke methods return JsonResponse.
     */
    public function testAllInvokeMethodsReturnJsonResponse(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionMethod($class, '__invoke');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame(
                JsonResponse::class,
                $returnType->getName(),
                "{$name}Controller::__invoke should return JsonResponse"
            );
        }
    }

    /**
     * Test CreateGameController injects correct handler type.
     */
    public function testCreateGameControllerInjectsCorrectHandler(): void
    {
        $reflection = new ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $this->assertCount(1, $params);
        $this->assertSame('handler', $params[0]->getName());
        $this->assertSame(
            GameManagementHandlerInterface::class,
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test GetGameController injects correct handler type.
     */
    public function testGetGameControllerInjectsCorrectHandler(): void
    {
        $reflection = new ReflectionClass(GetGameController::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $this->assertCount(1, $params);
        $this->assertSame('handler', $params[0]->getName());
        $this->assertSame(
            GameplayHandlerInterface::class,
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test GetLeaderboardController injects Statistics handler.
     */
    public function testGetLeaderboardControllerInjectsCorrectHandler(): void
    {
        $reflection = new ReflectionClass(GetLeaderboardController::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $this->assertCount(1, $params);
        $this->assertSame(
            StatisticsHandlerInterface::class,
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test CreateGameController __invoke has request parameter.
     */
    public function testCreateGameControllerInvokeHasRequestParameter(): void
    {
        $reflection = new ReflectionMethod(CreateGameController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertGreaterThanOrEqual(1, count($params));
        $this->assertSame('request', $params[0]->getName());
        $this->assertSame(
            CreateGameRequest::class,
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test GetGameController __invoke has path parameter.
     */
    public function testGetGameControllerInvokeHasPathParameter(): void
    {
        $reflection = new ReflectionMethod(GetGameController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertCount(2, $params);
        $this->assertSame('request', $params[0]->getName());
        $this->assertSame('game_id', $params[1]->getName());
        $this->assertSame('string', $params[1]->getType()->getName());
    }

    /**
     * Test GetSquareController __invoke has multiple path parameters.
     */
    public function testGetSquareControllerInvokeHasMultiplePathParameters(): void
    {
        $reflection = new ReflectionMethod(GetSquareController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertCount(4, $params);
        $this->assertSame('request', $params[0]->getName());
        $this->assertSame('game_id', $params[1]->getName());
        $this->assertSame('row', $params[2]->getName());
        $this->assertSame('column', $params[3]->getName());

        // Check types
        $this->assertSame('string', $params[1]->getType()->getName());
        $this->assertSame('int', $params[2]->getType()->getName());
        $this->assertSame('int', $params[3]->getType()->getName());
    }

    /**
     * Test GetPlayerStatsController __invoke has player_id path parameter.
     */
    public function testGetPlayerStatsControllerInvokeHasPathParameter(): void
    {
        $reflection = new ReflectionMethod(GetPlayerStatsController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertCount(2, $params);
        $this->assertSame('player_id', $params[1]->getName());
        $this->assertSame('string', $params[1]->getType()->getName());
    }

    /**
     * Test that constructor handler parameter is readonly.
     */
    public function testConstructorHandlerIsReadonly(): void
    {
        $reflection = new ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();
        $param = $constructor->getParameters()[0];

        // In PHP 8.1+, promoted properties have isPromoted()
        $this->assertTrue($param->isPromoted());
    }
}
