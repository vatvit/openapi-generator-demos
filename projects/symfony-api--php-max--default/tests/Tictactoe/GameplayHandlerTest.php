<?php

declare(strict_types=1);

namespace App\Tests\Tictactoe;

use PHPUnit\Framework\TestCase;
use App\Handler\GameplayHandler;
use TictactoeApi\Api\Handler\GameplayApiHandlerInterface;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Api\Response\GetBoard200Response;
use TictactoeApi\Api\Response\GetBoard404Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\GetMoves200Response;
use TictactoeApi\Api\Response\GetMoves404Response;
use TictactoeApi\Api\Response\GetSquare200Response;
use TictactoeApi\Api\Response\GetSquare400Response;
use TictactoeApi\Api\Response\GetSquare404Response;
use TictactoeApi\Api\Response\PutSquare200Response;
use TictactoeApi\Api\Response\PutSquare400Response;
use TictactoeApi\Api\Response\PutSquare404Response;
use TictactoeApi\Api\Response\PutSquare409Response;

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

    public function test_get_board_returns_200_response(): void
    {
        $result = $this->handler->getBoard('game_123');

        $this->assertInstanceOf(GetBoard200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_get_board_returns_404_for_notfound(): void
    {
        $result = $this->handler->getBoard('notfound_game');

        $this->assertInstanceOf(GetBoard404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    // --- getGame tests ---

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

    // --- getMoves tests ---

    public function test_get_moves_returns_200_response(): void
    {
        $result = $this->handler->getMoves('game_123');

        $this->assertInstanceOf(GetMoves200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_get_moves_returns_404_for_notfound(): void
    {
        $result = $this->handler->getMoves('notfound_game');

        $this->assertInstanceOf(GetMoves404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    // --- getSquare tests ---

    public function test_get_square_returns_200_response(): void
    {
        $result = $this->handler->getSquare('game_123', 1, 1);

        $this->assertInstanceOf(GetSquare200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_get_square_returns_400_for_invalid_coordinates(): void
    {
        $result = $this->handler->getSquare('game_123', 0, 1);
        $this->assertInstanceOf(GetSquare400Response::class, $result);
        $this->assertEquals(400, $result->getStatusCode());

        $result = $this->handler->getSquare('game_123', 4, 1);
        $this->assertInstanceOf(GetSquare400Response::class, $result);

        $result = $this->handler->getSquare('game_123', 1, 0);
        $this->assertInstanceOf(GetSquare400Response::class, $result);

        $result = $this->handler->getSquare('game_123', 1, 4);
        $this->assertInstanceOf(GetSquare400Response::class, $result);
    }

    public function test_get_square_returns_404_for_notfound(): void
    {
        $result = $this->handler->getSquare('notfound_game', 1, 1);

        $this->assertInstanceOf(GetSquare404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    // --- putSquare tests ---

    public function test_put_square_returns_200_response(): void
    {
        $request = new MoveRequest(mark: 'X');
        $result = $this->handler->putSquare('game_123', 1, 1, $request);

        $this->assertInstanceOf(PutSquare200Response::class, $result);
        $this->assertEquals(200, $result->getStatusCode());
    }

    public function test_put_square_returns_400_for_invalid_coordinates(): void
    {
        $request = new MoveRequest(mark: 'X');
        $result = $this->handler->putSquare('game_123', 0, 1, $request);

        $this->assertInstanceOf(PutSquare400Response::class, $result);
        $this->assertEquals(400, $result->getStatusCode());
    }

    public function test_put_square_returns_404_for_notfound(): void
    {
        $request = new MoveRequest(mark: 'X');
        $result = $this->handler->putSquare('notfound_game', 1, 1, $request);

        $this->assertInstanceOf(PutSquare404Response::class, $result);
        $this->assertEquals(404, $result->getStatusCode());
    }

    public function test_put_square_returns_409_for_occupied_square(): void
    {
        // First move
        $request = new MoveRequest(mark: 'X');
        $this->handler->putSquare('game_conflict', 1, 1, $request);

        // Try to place on same square
        $request2 = new MoveRequest(mark: 'O');
        $result = $this->handler->putSquare('game_conflict', 1, 1, $request2);

        $this->assertInstanceOf(PutSquare409Response::class, $result);
        $this->assertEquals(409, $result->getStatusCode());
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
            $this->assertInstanceOf(PutSquare200Response::class, $result);
        }

        // Try to make another move after game is finished
        $request = new MoveRequest(mark: 'O');
        $result = $this->handler->putSquare($gameId, 3, 1, $request);
        $this->assertInstanceOf(PutSquare409Response::class, $result);
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
        $this->assertInstanceOf(GetMoves200Response::class, $result);
    }
}
