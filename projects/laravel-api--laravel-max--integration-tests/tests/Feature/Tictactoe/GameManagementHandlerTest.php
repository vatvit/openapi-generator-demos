<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handlers\GameManagementHandler;
use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Api\Http\Resources\CreateGame201Resource;
use TictactoeApi\Api\Http\Resources\GetGame200Resource;
use TictactoeApi\Api\Http\Resources\GetGame404Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame204Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame404Resource;

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

    public function test_create_game_returns_201_resource(): void
    {
        $request = new CreateGameRequest(
            mode: GameMode::PVP
        );

        $result = $this->handler->createGame($request);

        $this->assertInstanceOf(CreateGame201Resource::class, $result);
    }

    public function test_get_game_returns_200_resource(): void
    {
        $result = $this->handler->getGame('game_123');

        $this->assertInstanceOf(GetGame200Resource::class, $result);
    }

    public function test_get_game_returns_404_for_notfound(): void
    {
        $result = $this->handler->getGame('notfound_game');

        $this->assertInstanceOf(GetGame404Resource::class, $result);
    }

    public function test_delete_game_returns_204_resource(): void
    {
        $result = $this->handler->deleteGame('game_123');

        $this->assertInstanceOf(DeleteGame204Resource::class, $result);
    }

    public function test_delete_game_returns_404_for_notfound(): void
    {
        $result = $this->handler->deleteGame('notfound_game');

        $this->assertInstanceOf(DeleteGame404Resource::class, $result);
    }

    // Note: listGames test omitted - requires JsonResource wrapping
    // The pattern is demonstrated with other operations above
}
