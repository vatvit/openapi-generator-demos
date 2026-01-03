<?php

declare(strict_types=1);

namespace App\Tests\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handler\GameManagementHandler;
use TictactoeApi\Api\Handler\GameManagementApiHandlerInterface;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\DeleteGame204Response;
use TictactoeApi\Api\Response\DeleteGame404Response;

/**
 * Tests for GameManagement Handler Implementation
 *
 * Demonstrates how application-level handlers implement generated interfaces
 */
class GameManagementHandlerTest extends TestCase
{
    private GameManagementHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new GameManagementHandler();
    }

    public function test_handler_implements_interface(): void
    {
        $this->assertInstanceOf(
            GameManagementApiHandlerInterface::class,
            $this->handler,
            'Handler should implement GameManagementApiHandlerInterface'
        );
    }

    public function test_create_game_returns_201_response(): void
    {
        $request = new CreateGameRequest(
            mode: GameMode::PVP
        );

        $result = $this->handler->createGame($request);

        $this->assertInstanceOf(CreateGame201Response::class, $result);
        $this->assertEquals(201, $result->getStatusCode());
    }

    public function test_get_game_returns_200_response(): void
    {
        $result = $this->handler->getGame('game_123');

        $this->assertInstanceOf(GetGame200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_get_game_returns_404_for_notfound(): void
    {
        $result = $this->handler->getGame('notfound_game');

        $this->assertInstanceOf(GetGame404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    public function test_delete_game_returns_204_response(): void
    {
        $result = $this->handler->deleteGame('game_123');

        $this->assertInstanceOf(DeleteGame204Response::class, $result);
        $this->assertEquals(204, $result->getStatusCode());
    }

    public function test_delete_game_returns_404_for_notfound(): void
    {
        $result = $this->handler->deleteGame('notfound_game');

        $this->assertInstanceOf(DeleteGame404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }
}
