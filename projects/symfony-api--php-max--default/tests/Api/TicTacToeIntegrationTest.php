<?php

declare(strict_types=1);

namespace App\Tests\Api;

use PHPUnit\Framework\TestCase;
use App\Handler\GameManagementHandler;
use App\Handler\GameplayHandler;
use App\Handler\StatisticsHandler;
use TictactoeApi\Api\Handler\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Handler\GameplayApiHandlerInterface;
use TictactoeApi\Api\Handler\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\DeleteGame204Response;
use TictactoeApi\Api\Response\ListGames200Response;
use TictactoeApi\Api\Response\GetBoard200Response;
use TictactoeApi\Api\Response\GetLeaderboard200Response;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\GameMode;

/**
 * Integration tests for TicTacToe API (symfony-max generator).
 *
 * These tests verify:
 * 1. Generated models can be instantiated
 * 2. Handler implementations satisfy per-tag interfaces
 * 3. Union return types work correctly
 * 4. Response DTOs function properly
 */
class TicTacToeIntegrationTest extends TestCase
{
    private GameManagementHandler $gameManagementHandler;
    private GameplayHandler $gameplayHandler;
    private StatisticsHandler $statisticsHandler;

    protected function setUp(): void
    {
        GameplayHandler::resetGames();
        $this->gameManagementHandler = new GameManagementHandler();
        $this->gameplayHandler = new GameplayHandler();
        $this->statisticsHandler = new StatisticsHandler();
    }

    // =========================================================================
    // Interface Implementation Tests (Per-Tag Interfaces)
    // =========================================================================

    public function testGameManagementHandlerImplementsInterface(): void
    {
        $this->assertInstanceOf(
            GameManagementApiHandlerInterface::class,
            $this->gameManagementHandler,
            'Handler must implement GameManagementApiHandlerInterface'
        );
    }

    public function testGameplayHandlerImplementsInterface(): void
    {
        $this->assertInstanceOf(
            GameplayApiHandlerInterface::class,
            $this->gameplayHandler,
            'Handler must implement GameplayApiHandlerInterface'
        );
    }

    public function testStatisticsHandlerImplementsInterface(): void
    {
        $this->assertInstanceOf(
            StatisticsApiHandlerInterface::class,
            $this->statisticsHandler,
            'Handler must implement StatisticsApiHandlerInterface'
        );
    }

    // =========================================================================
    // Generated Model Tests
    // =========================================================================

    public function testGeneratedModelsExist(): void
    {
        $this->assertTrue(class_exists(Game::class), 'Game model should exist');
        $this->assertTrue(class_exists(CreateGameRequest::class), 'CreateGameRequest model should exist');
    }

    public function testGeneratedEnumsExist(): void
    {
        $this->assertTrue(enum_exists(GameStatus::class), 'GameStatus enum should exist');
        $this->assertTrue(enum_exists(GameMode::class), 'GameMode enum should exist');
    }

    public function testGameStatusEnumValues(): void
    {
        $this->assertEquals('pending', GameStatus::PENDING->value);
        $this->assertEquals('in_progress', GameStatus::IN_PROGRESS->value);
        $this->assertEquals('completed', GameStatus::COMPLETED->value);
        $this->assertEquals('abandoned', GameStatus::ABANDONED->value);
    }

    public function testGameModeEnumValues(): void
    {
        $this->assertEquals('pvp', GameMode::PVP->value);
        $this->assertEquals('ai_easy', GameMode::AI_EASY->value);
        $this->assertEquals('ai_medium', GameMode::AI_MEDIUM->value);
        $this->assertEquals('ai_hard', GameMode::AI_HARD->value);
    }

    // =========================================================================
    // Response DTO Tests (Union Return Types)
    // =========================================================================

    public function testCreateGameReturns201Response(): void
    {
        $request = new CreateGameRequest(
            mode: GameMode::PVP
        );

        $response = $this->gameManagementHandler->createGame($request);

        $this->assertInstanceOf(CreateGame201Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertInstanceOf(Game::class, $response->getData());
    }

    public function testGetGameReturns200Response(): void
    {
        $response = $this->gameManagementHandler->getGame('existing-game-id');

        $this->assertInstanceOf(GetGame200Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertInstanceOf(Game::class, $response->getData());
    }

    public function testGetGameReturns404ForNotFound(): void
    {
        $response = $this->gameManagementHandler->getGame('notfound_game');

        $this->assertInstanceOf(GetGame404Response::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testDeleteGameReturns204Response(): void
    {
        $response = $this->gameManagementHandler->deleteGame('game-to-delete');

        $this->assertInstanceOf(DeleteGame204Response::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    public function testListGamesReturns200Response(): void
    {
        $response = $this->gameManagementHandler->listGames();

        $this->assertInstanceOf(ListGames200Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetBoardReturns200Response(): void
    {
        $response = $this->gameplayHandler->getBoard('game-id');

        $this->assertInstanceOf(GetBoard200Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGetLeaderboardReturns200Response(): void
    {
        $response = $this->statisticsHandler->getLeaderboard();

        $this->assertInstanceOf(GetLeaderboard200Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    // =========================================================================
    // Generated Interface Tests
    // =========================================================================

    public function testGeneratedInterfacesExist(): void
    {
        $this->assertTrue(
            interface_exists(GameManagementApiHandlerInterface::class),
            'GameManagementApiHandlerInterface should exist'
        );
        $this->assertTrue(
            interface_exists(GameplayApiHandlerInterface::class),
            'GameplayApiHandlerInterface should exist'
        );
        $this->assertTrue(
            interface_exists(StatisticsApiHandlerInterface::class),
            'StatisticsApiHandlerInterface should exist'
        );
    }

    // =========================================================================
    // Response DTO Structure Tests
    // =========================================================================

    public function testResponseDtosExist(): void
    {
        $this->assertTrue(
            class_exists(CreateGame201Response::class),
            'CreateGame201Response should exist'
        );
        $this->assertTrue(
            class_exists(GetGame200Response::class),
            'GetGame200Response should exist'
        );
        $this->assertTrue(
            class_exists(GetGame404Response::class),
            'GetGame404Response should exist'
        );
    }

    public function testResponseDtoHasCorrectMethods(): void
    {
        $request = new CreateGameRequest(mode: GameMode::PVP);
        $response = $this->gameManagementHandler->createGame($request);

        $this->assertTrue(method_exists($response, 'getStatusCode'));
        $this->assertTrue(method_exists($response, 'getData'));
        $this->assertTrue(method_exists($response, 'getHeaders'));
        $this->assertTrue(method_exists($response, 'withHeader'));
    }
}
