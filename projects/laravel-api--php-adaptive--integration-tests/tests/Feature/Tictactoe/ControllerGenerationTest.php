<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
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
use TicTacToeApi\Api\TicTacHandlerInterface;
use TicTacToeApi\Http\Requests\CreateGameRequest;
use TicTacToeApi\Http\Requests\DeleteGameRequest;
use TicTacToeApi\Http\Requests\GetBoardRequest;
use TicTacToeApi\Http\Requests\GetGameRequest;
use TicTacToeApi\Http\Requests\GetLeaderboardRequest;
use TicTacToeApi\Http\Requests\GetMovesRequest;
use TicTacToeApi\Http\Requests\GetPlayerStatsRequest;
use TicTacToeApi\Http\Requests\GetSquareRequest;
use TicTacToeApi\Http\Requests\ListGamesRequest;
use TicTacToeApi\Http\Requests\PutSquareRequest;
use ReflectionClass;

/**
 * Tests that verify the generated controller classes behave correctly.
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
     * Test that all controllers can be instantiated with handler.
     */
    public function testAllControllersCanBeInstantiated(): void
    {
        // Test GameManagement controllers
        $gameManagementMock = $this->createMock(GameManagementHandlerInterface::class);
        $this->assertInstanceOf(CreateGameController::class, new CreateGameController($gameManagementMock));
        $this->assertInstanceOf(ListGamesController::class, new ListGamesController($gameManagementMock));
        $this->assertInstanceOf(DeleteGameController::class, new DeleteGameController($gameManagementMock));

        // Test Gameplay controllers
        $gameplayMock = $this->createMock(GameplayHandlerInterface::class);
        $this->assertInstanceOf(GetGameController::class, new GetGameController($gameplayMock));
        $this->assertInstanceOf(GetSquareController::class, new GetSquareController($gameplayMock));
        $this->assertInstanceOf(PutSquareController::class, new PutSquareController($gameplayMock));
        $this->assertInstanceOf(GetMovesController::class, new GetMovesController($gameplayMock));

        // Test TicTac controllers
        $ticTacMock = $this->createMock(TicTacHandlerInterface::class);
        $this->assertInstanceOf(GetBoardController::class, new GetBoardController($ticTacMock));

        // Test Statistics controllers
        $statisticsMock = $this->createMock(StatisticsHandlerInterface::class);
        $this->assertInstanceOf(GetLeaderboardController::class, new GetLeaderboardController($statisticsMock));
        $this->assertInstanceOf(GetPlayerStatsController::class, new GetPlayerStatsController($statisticsMock));
    }

    /**
     * Test that CreateGameController constructor accepts correct handler.
     */
    public function testCreateGameControllerConstructor(): void
    {
        $handler = $this->createMock(GameManagementHandlerInterface::class);
        $controller = new CreateGameController($handler);
        $this->assertInstanceOf(CreateGameController::class, $controller);
    }

    /**
     * Test that ListGamesController constructor accepts correct handler.
     */
    public function testListGamesControllerConstructor(): void
    {
        $handler = $this->createMock(GameManagementHandlerInterface::class);
        $controller = new ListGamesController($handler);
        $this->assertInstanceOf(ListGamesController::class, $controller);
    }

    /**
     * Test GetGameController returns JsonResponse with path parameter.
     */
    public function testGetGameControllerReturnsJsonResponseWithPathParam(): void
    {
        $handler = $this->createMock(GameplayHandlerInterface::class);
        $handler->method('getGame')
            ->willReturn(new JsonResponse(['id' => 'game-123']));

        $controller = new GetGameController($handler);
        $request = new GetGameRequest();

        $response = $controller($request, 'game-123');
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test DeleteGameController returns JsonResponse.
     */
    public function testDeleteGameControllerReturnsJsonResponse(): void
    {
        $handler = $this->createMock(GameManagementHandlerInterface::class);
        $handler->method('deleteGame')
            ->willReturn(new JsonResponse(null, 204));

        $controller = new DeleteGameController($handler);
        $request = new DeleteGameRequest();

        $response = $controller($request, 'game-123');
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test GetBoardController returns JsonResponse.
     */
    public function testGetBoardControllerReturnsJsonResponse(): void
    {
        $handler = $this->createMock(TicTacHandlerInterface::class);
        $handler->method('getBoard')
            ->willReturn(new JsonResponse(['board' => []]));

        $controller = new GetBoardController($handler);
        $request = new GetBoardRequest();

        $response = $controller($request, 'game-123');
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test GetSquareController handles multiple path parameters.
     */
    public function testGetSquareControllerHandlesMultiplePathParams(): void
    {
        $handler = $this->createMock(GameplayHandlerInterface::class);
        $handler->method('getSquare')
            ->willReturn(new JsonResponse(['row' => 0, 'column' => 1, 'mark' => 'X']));

        $controller = new GetSquareController($handler);
        $request = new GetSquareRequest();

        // Call with game_id, row, column path parameters
        $response = $controller($request, 'game-123', 0, 1);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test PutSquareController constructor accepts correct handler.
     */
    public function testPutSquareControllerConstructor(): void
    {
        $handler = $this->createMock(GameplayHandlerInterface::class);
        $controller = new PutSquareController($handler);
        $this->assertInstanceOf(PutSquareController::class, $controller);
    }

    /**
     * Test GetMovesController returns JsonResponse.
     */
    public function testGetMovesControllerReturnsJsonResponse(): void
    {
        $handler = $this->createMock(GameplayHandlerInterface::class);
        $handler->method('getMoves')
            ->willReturn(new JsonResponse(['game_id' => 'game-123', 'moves' => []]));

        $controller = new GetMovesController($handler);
        $request = new GetMovesRequest();

        $response = $controller($request, 'game-123');
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test GetLeaderboardController constructor accepts correct handler.
     */
    public function testGetLeaderboardControllerConstructor(): void
    {
        $handler = $this->createMock(StatisticsHandlerInterface::class);
        $controller = new GetLeaderboardController($handler);
        $this->assertInstanceOf(GetLeaderboardController::class, $controller);
    }

    /**
     * Test GetPlayerStatsController handles player_id path parameter.
     */
    public function testGetPlayerStatsControllerHandlesPathParam(): void
    {
        $handler = $this->createMock(StatisticsHandlerInterface::class);
        $handler->method('getPlayerStats')
            ->willReturn(new JsonResponse(['player' => ['id' => 'p1']]));

        $controller = new GetPlayerStatsController($handler);
        $request = new GetPlayerStatsRequest();

        $response = $controller($request, 'player-123');
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test that controller handler is promoted property (readonly).
     */
    public function testControllerHandlerIsPromotedProperty(): void
    {
        $reflection = new ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();
        $this->assertNotNull($constructor);

        $params = $constructor->getParameters();
        $this->assertCount(1, $params);
        $this->assertTrue($params[0]->isPromoted(), 'Handler should be a promoted property');
    }
}
