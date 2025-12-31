<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handlers\GameplayHandler;
use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Api\Http\Resources\GetBoard200Resource;
use TictactoeApi\Api\Http\Resources\GetBoard404Resource;
use TictactoeApi\Api\Http\Resources\GetGame200Resource;
use TictactoeApi\Api\Http\Resources\GetGame404Resource;
use TictactoeApi\Api\Http\Resources\GetMoves200Resource;
use TictactoeApi\Api\Http\Resources\GetMoves404Resource;
use TictactoeApi\Api\Http\Resources\GetSquare200Resource;
use TictactoeApi\Api\Http\Resources\GetSquare400Resource;
use TictactoeApi\Api\Http\Resources\GetSquare404Resource;
use TictactoeApi\Api\Http\Resources\PutSquare200Resource;
use TictactoeApi\Api\Http\Resources\PutSquare400Resource;
use TictactoeApi\Api\Http\Resources\PutSquare404Resource;
use TictactoeApi\Api\Http\Resources\PutSquare409Resource;

/**
 * Tests for Gameplay Handler Implementation
 */
class GameplayHandlerTest extends TestCase
{
    private GameplayHandler $handler;

    protected function setUp(): void
    {
        GameplayHandler::resetGames();
        $this->handler = new GameplayHandler();
    }

    public function test_handler_implements_interface(): void
    {
        $this->assertInstanceOf(
            GameplayApiHandlerInterface::class,
            $this->handler,
            'Handler should implement GameplayApiHandlerInterface'
        );
    }

    // --- getBoard tests ---

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

    // --- getGame tests ---

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

    // --- getMoves tests ---

    public function test_get_moves_returns_200_resource(): void
    {
        $result = $this->handler->getMoves('game_123');

        $this->assertInstanceOf(GetMoves200Resource::class, $result);
    }

    public function test_get_moves_returns_404_for_notfound(): void
    {
        $result = $this->handler->getMoves('notfound_game');

        $this->assertInstanceOf(GetMoves404Resource::class, $result);
    }

    // --- getSquare tests ---

    public function test_get_square_returns_200_resource(): void
    {
        $result = $this->handler->getSquare('game_123', 1, 1);

        $this->assertInstanceOf(GetSquare200Resource::class, $result);
    }

    public function test_get_square_returns_400_for_invalid_coordinates(): void
    {
        $result = $this->handler->getSquare('game_123', 0, 1);
        $this->assertInstanceOf(GetSquare400Resource::class, $result);

        $result = $this->handler->getSquare('game_123', 4, 1);
        $this->assertInstanceOf(GetSquare400Resource::class, $result);

        $result = $this->handler->getSquare('game_123', 1, 0);
        $this->assertInstanceOf(GetSquare400Resource::class, $result);

        $result = $this->handler->getSquare('game_123', 1, 4);
        $this->assertInstanceOf(GetSquare400Resource::class, $result);
    }

    public function test_get_square_returns_404_for_notfound(): void
    {
        $result = $this->handler->getSquare('notfound_game', 1, 1);

        $this->assertInstanceOf(GetSquare404Resource::class, $result);
    }

    // --- putSquare tests ---

    public function test_put_square_returns_200_resource(): void
    {
        $request = new MoveRequest(mark: 'X');
        $result = $this->handler->putSquare('game_123', 1, 1, $request);

        $this->assertInstanceOf(PutSquare200Resource::class, $result);
    }

    public function test_put_square_returns_400_for_invalid_coordinates(): void
    {
        $request = new MoveRequest(mark: 'X');
        $result = $this->handler->putSquare('game_123', 0, 1, $request);

        $this->assertInstanceOf(PutSquare400Resource::class, $result);
    }

    public function test_put_square_returns_400_for_invalid_mark(): void
    {
        $request = new MoveRequest(mark: 'Z');
        $result = $this->handler->putSquare('game_123', 1, 1, $request);

        $this->assertInstanceOf(PutSquare400Resource::class, $result);
    }

    public function test_put_square_returns_404_for_notfound(): void
    {
        $request = new MoveRequest(mark: 'X');
        $result = $this->handler->putSquare('notfound_game', 1, 1, $request);

        $this->assertInstanceOf(PutSquare404Resource::class, $result);
    }

    public function test_put_square_returns_409_for_occupied_square(): void
    {
        // First move
        $request = new MoveRequest(mark: 'X');
        $this->handler->putSquare('game_conflict', 1, 1, $request);

        // Try to place on same square
        $request2 = new MoveRequest(mark: 'O');
        $result = $this->handler->putSquare('game_conflict', 1, 1, $request2);

        $this->assertInstanceOf(PutSquare409Resource::class, $result);
    }

    // --- Game flow tests ---

    public function test_complete_game_flow(): void
    {
        $gameId = 'game_flow_test';

        // X wins with top row
        $moves = [
            ['X', 1, 1], // X at (1,1)
            ['O', 2, 1], // O at (2,1)
            ['X', 1, 2], // X at (1,2)
            ['O', 2, 2], // O at (2,2)
            ['X', 1, 3], // X at (1,3) - X wins!
        ];

        foreach ($moves as $move) {
            $request = new MoveRequest(mark: $move[0]);
            $result = $this->handler->putSquare($gameId, $move[1], $move[2], $request);
            $this->assertInstanceOf(PutSquare200Resource::class, $result);
        }

        // Try to make another move after game is finished
        $request = new MoveRequest(mark: 'O');
        $result = $this->handler->putSquare($gameId, 3, 1, $request);
        $this->assertInstanceOf(PutSquare409Resource::class, $result);
    }

    public function test_moves_are_recorded(): void
    {
        $gameId = 'game_moves_test';

        // Make some moves
        $request = new MoveRequest(mark: 'X');
        $this->handler->putSquare($gameId, 1, 1, $request);

        $request = new MoveRequest(mark: 'O');
        $this->handler->putSquare($gameId, 2, 2, $request);

        // Get moves
        $result = $this->handler->getMoves($gameId);
        $this->assertInstanceOf(GetMoves200Resource::class, $result);
    }
}
