<?php

declare(strict_types=1);

namespace Tests\Api;

use Tests\TestCase;
use App\Api\TicTacToe\GameManagementHandler;
use TicTacToeApi\Api\GameManagementApiInterface;
use TicTacToeApi\Model\Game;
use TicTacToeApi\Model\GameListResponse;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\GameMode;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\NoContent204;

/**
 * Integration tests for TicTacToe API.
 *
 * These tests verify:
 * 1. Generated models can be instantiated
 * 2. Handler implementations satisfy interfaces
 * 3. Return types are enforced
 */
class TicTacToeIntegrationTest extends TestCase
{
    private GameManagementHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new GameManagementHandler();
    }

    public function test_handler_implements_interface(): void
    {
        $this->assertInstanceOf(
            GameManagementApiInterface::class,
            $this->handler,
            'Handler must implement generated interface'
        );
    }

    public function test_generated_models_exist(): void
    {
        $this->assertTrue(class_exists(Game::class), 'Game model should exist');
        $this->assertTrue(class_exists(GameListResponse::class), 'GameListResponse model should exist');
        $this->assertTrue(class_exists(CreateGameRequest::class), 'CreateGameRequest model should exist');
        $this->assertTrue(class_exists(NoContent204::class), 'NoContent204 model should exist');
    }

    public function test_generated_enums_exist(): void
    {
        $this->assertTrue(enum_exists(GameStatus::class), 'GameStatus enum should exist');
        $this->assertTrue(enum_exists(GameMode::class), 'GameMode enum should exist');
    }

    public function test_game_status_enum_values(): void
    {
        $this->assertEquals('pending', GameStatus::PENDING->value);
        $this->assertEquals('in_progress', GameStatus::IN_PROGRESS->value);
        $this->assertEquals('completed', GameStatus::COMPLETED->value);
        $this->assertEquals('abandoned', GameStatus::ABANDONED->value);
    }

    public function test_game_mode_enum_values(): void
    {
        $this->assertEquals('pvp', GameMode::PVP->value);
        $this->assertEquals('ai_easy', GameMode::AI_EASY->value);
        $this->assertEquals('ai_medium', GameMode::AI_MEDIUM->value);
        $this->assertEquals('ai_hard', GameMode::AI_HARD->value);
    }

    public function test_delete_game_returns_no_content(): void
    {
        $result = $this->handler->deleteGame('game-to-delete');

        $this->assertInstanceOf(NoContent204::class, $result, 'Delete should return NoContent204');
    }

    public function test_generated_interfaces_exist(): void
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
