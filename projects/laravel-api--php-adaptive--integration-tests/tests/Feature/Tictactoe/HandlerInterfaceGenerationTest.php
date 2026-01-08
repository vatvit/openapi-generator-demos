<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Illuminate\Http\JsonResponse;
use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Api\TicTacHandlerInterface;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\MoveRequest;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\GameMode;

/**
 * Tests that verify the generated handler interfaces behave correctly.
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
     * Test that mock implementations can be created for all interfaces.
     */
    public function testMockImplementationsCanBeCreated(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $mock = $this->createMock($interface);
            $this->assertInstanceOf(
                $interface,
                $mock,
                "Should be able to create mock for {$name}"
            );
        }
    }

    /**
     * Test GameManagementHandlerInterface has expected methods.
     */
    public function testGameManagementHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['createGame', 'deleteGame', 'getGame', 'listGames'];

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(GameManagementHandlerInterface::class, $method),
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

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(GameplayHandlerInterface::class, $method),
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

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(StatisticsHandlerInterface::class, $method),
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

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(TicTacHandlerInterface::class, $method),
                "TicTacHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test that GameManagementHandlerInterface methods return JsonResponse.
     */
    public function testGameManagementMethodsReturnJsonResponse(): void
    {
        $mock = $this->createMock(GameManagementHandlerInterface::class);

        $mock->method('createGame')->willReturn(new JsonResponse(['id' => 'game-123'], 201));
        $mock->method('deleteGame')->willReturn(new JsonResponse(null, 204));
        $mock->method('getGame')->willReturn(new JsonResponse(['id' => 'game-123']));
        $mock->method('listGames')->willReturn(new JsonResponse(['games' => []]));

        $createRequest = new CreateGameRequest(GameMode::PVP);
        $this->assertInstanceOf(JsonResponse::class, $mock->createGame($createRequest));
        $this->assertInstanceOf(JsonResponse::class, $mock->deleteGame('game-123'));
        $this->assertInstanceOf(JsonResponse::class, $mock->getGame('game-123'));
        $this->assertInstanceOf(JsonResponse::class, $mock->listGames());
    }

    /**
     * Test that GameplayHandlerInterface methods return JsonResponse.
     */
    public function testGameplayMethodsReturnJsonResponse(): void
    {
        $mock = $this->createMock(GameplayHandlerInterface::class);

        $mock->method('getBoard')->willReturn(new JsonResponse(['board' => []]));
        $mock->method('getGame')->willReturn(new JsonResponse(['id' => 'game-123']));
        $mock->method('getMoves')->willReturn(new JsonResponse(['moves' => []]));
        $mock->method('getSquare')->willReturn(new JsonResponse(['mark' => 'X']));
        $mock->method('putSquare')->willReturn(new JsonResponse(['mark' => 'X']));

        $this->assertInstanceOf(JsonResponse::class, $mock->getBoard('game-123'));
        $this->assertInstanceOf(JsonResponse::class, $mock->getGame('game-123'));
        $this->assertInstanceOf(JsonResponse::class, $mock->getMoves('game-123'));
        $this->assertInstanceOf(JsonResponse::class, $mock->getSquare('game-123', 0, 0));

        $moveRequest = MoveRequest::fromArray(['mark' => 'X']);
        $this->assertInstanceOf(JsonResponse::class, $mock->putSquare('game-123', 0, 0, $moveRequest));
    }

    /**
     * Test that StatisticsHandlerInterface methods return JsonResponse.
     */
    public function testStatisticsMethodsReturnJsonResponse(): void
    {
        $mock = $this->createMock(StatisticsHandlerInterface::class);

        $mock->method('getLeaderboard')->willReturn(new JsonResponse(['entries' => []]));
        $mock->method('getPlayerStats')->willReturn(new JsonResponse(['player' => []]));

        $this->assertInstanceOf(JsonResponse::class, $mock->getLeaderboard());
        $this->assertInstanceOf(JsonResponse::class, $mock->getPlayerStats('player-123'));
    }

    /**
     * Test createGame method accepts CreateGameRequest parameter.
     */
    public function testCreateGameAcceptsCreateGameRequest(): void
    {
        $mock = $this->createMock(GameManagementHandlerInterface::class);
        $mock->expects($this->once())
            ->method('createGame')
            ->with($this->isInstanceOf(CreateGameRequest::class))
            ->willReturn(new JsonResponse(['id' => 'game-123'], 201));

        $request = new CreateGameRequest(GameMode::PVP);
        $mock->createGame($request);
    }

    /**
     * Test listGames method accepts optional parameters.
     */
    public function testListGamesAcceptsOptionalParameters(): void
    {
        $mock = $this->createMock(GameManagementHandlerInterface::class);
        $mock->method('listGames')->willReturn(new JsonResponse(['games' => []]));

        // Call with no parameters (all optional)
        $result1 = $mock->listGames();
        $this->assertInstanceOf(JsonResponse::class, $result1);

        // Call with some parameters
        $result2 = $mock->listGames(1, 10);
        $this->assertInstanceOf(JsonResponse::class, $result2);

        // Call with all parameters
        $result3 = $mock->listGames(1, 10, GameStatus::IN_PROGRESS, 'player-123');
        $this->assertInstanceOf(JsonResponse::class, $result3);
    }

    /**
     * Test getGame method requires game_id parameter.
     */
    public function testGetGameRequiresGameId(): void
    {
        $mock = $this->createMock(GameManagementHandlerInterface::class);
        $mock->expects($this->once())
            ->method('getGame')
            ->with($this->equalTo('game-123'))
            ->willReturn(new JsonResponse(['id' => 'game-123']));

        $mock->getGame('game-123');
    }

    /**
     * Test putSquare method requires path params and body DTO.
     */
    public function testPutSquareRequiresAllParameters(): void
    {
        $mock = $this->createMock(GameplayHandlerInterface::class);
        $mock->expects($this->once())
            ->method('putSquare')
            ->with(
                $this->equalTo('game-123'),
                $this->equalTo(1),
                $this->equalTo(2),
                $this->isInstanceOf(MoveRequest::class)
            )
            ->willReturn(new JsonResponse(['mark' => 'X']));

        $moveRequest = MoveRequest::fromArray(['mark' => 'X']);
        $mock->putSquare('game-123', 1, 2, $moveRequest);
    }

    /**
     * Test getPlayerStats method requires player_id parameter.
     */
    public function testGetPlayerStatsRequiresPlayerId(): void
    {
        $mock = $this->createMock(StatisticsHandlerInterface::class);
        $mock->expects($this->once())
            ->method('getPlayerStats')
            ->with($this->equalTo('player-123'))
            ->willReturn(new JsonResponse(['player' => []]));

        $mock->getPlayerStats('player-123');
    }

    /**
     * Test getLeaderboard method accepts optional parameters.
     */
    public function testGetLeaderboardAcceptsOptionalParameters(): void
    {
        $mock = $this->createMock(StatisticsHandlerInterface::class);
        $mock->method('getLeaderboard')->willReturn(new JsonResponse(['entries' => []]));

        // Call with no parameters
        $result1 = $mock->getLeaderboard();
        $this->assertInstanceOf(JsonResponse::class, $result1);

        // Call with parameters
        $result2 = $mock->getLeaderboard(null, 10);
        $this->assertInstanceOf(JsonResponse::class, $result2);
    }

    /**
     * Test that all interface methods are public.
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
