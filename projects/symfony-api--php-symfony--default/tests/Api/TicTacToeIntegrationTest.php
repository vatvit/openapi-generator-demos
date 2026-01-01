<?php

declare(strict_types=1);

namespace App\Tests\Api;

use PHPUnit\Framework\TestCase;
use App\Handler\TicTacToe\GameManagementHandler;
use TicTacToeApi\Model\Game;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\GameMode;
use TicTacToeApi\Api\GameManagementApiInterface;

/**
 * Integration tests for TicTacToe API.
 *
 * These tests verify:
 * 1. Generated models can be instantiated
 * 2. Handler implementations satisfy interfaces
 * 3. Business logic works correctly
 */
class TicTacToeIntegrationTest extends TestCase
{
    private GameManagementHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new GameManagementHandler();
    }

    public function testHandlerImplementsInterface(): void
    {
        $this->assertInstanceOf(
            GameManagementApiInterface::class,
            $this->handler,
            'Handler must implement generated interface'
        );
    }

    public function testGeneratedModelsExist(): void
    {
        $this->assertTrue(class_exists(Game::class), 'Game model should exist');
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

    public function testDeleteGame(): void
    {
        $responseCode = 0;
        $responseHeaders = [];

        $this->handler->deleteGame('game-to-delete', $responseCode, $responseHeaders);

        $this->assertEquals(204, $responseCode, 'Delete should return 204 status');
    }

    public function testGeneratedInterfacesExist(): void
    {
        $this->assertTrue(
            interface_exists(GameManagementApiInterface::class),
            'GameManagementApiInterface should exist'
        );
        $this->assertTrue(
            interface_exists(\TicTacToeApi\Api\GameplayApiInterface::class),
            'GameplayApiInterface should exist'
        );
        $this->assertTrue(
            interface_exists(\TicTacToeApi\Api\StatisticsApiInterface::class),
            'StatisticsApiInterface should exist'
        );
    }
}
