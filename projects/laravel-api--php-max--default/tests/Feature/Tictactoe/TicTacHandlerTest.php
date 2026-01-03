<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handlers\TicTacHandler;
use App\Handlers\GameplayHandler;
use TictactoeApi\Api\Handlers\TicTacApiHandlerInterface;
use TictactoeApi\Api\Http\Resources\GetBoard200Resource;
use TictactoeApi\Api\Http\Resources\GetBoard404Resource;

/**
 * Tests for TicTac Handler Implementation
 */
class TicTacHandlerTest extends TestCase
{
    private TicTacHandler $handler;

    protected function setUp(): void
    {
        GameplayHandler::resetGames();
        $this->handler = new TicTacHandler();
    }

    public function test_handler_implements_interface(): void
    {
        $this->assertInstanceOf(
            TicTacApiHandlerInterface::class,
            $this->handler,
            'Handler should implement TicTacApiHandlerInterface'
        );
    }

    public function test_get_board_returns_200_resource(): void
    {
        $result = $this->handler->getBoard('game_123');

        $this->assertInstanceOf(GetBoard200Resource::class, $result);
    }

    public function test_get_board_returns_404_for_notfound(): void
    {
        $result = $this->handler->getBoard('notfound_game');

        $this->assertInstanceOf(GetBoard404Resource::class, $result);
    }
}
