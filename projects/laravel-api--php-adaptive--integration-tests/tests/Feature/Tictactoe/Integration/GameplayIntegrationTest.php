<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe\Integration;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;
use TicTacToeApi\Model\MoveRequest;
use App\Handlers\Tictactoe\GameplayHandler;
use App\Handlers\Tictactoe\TicTacHandler;

/**
 * Integration tests for TicTacToe Gameplay operations.
 *
 * Tests the handler implementations with real model DTOs.
 */
class GameplayIntegrationTest extends TestCase
{
    private GameplayHandler $gameplayHandler;
    private TicTacHandler $ticTacHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gameplayHandler = new GameplayHandler();
        $this->ticTacHandler = new TicTacHandler();
    }

    /**
     * Test getBoard returns 200 with board data.
     */
    public function testGetBoardReturns200WithBoardData(): void
    {
        $response = $this->ticTacHandler->getBoard('game-123');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('gameId', $data);
        $this->assertArrayHasKey('board', $data);
        $this->assertArrayHasKey('currentTurn', $data);
        $this->assertEquals('game-123', $data['gameId']);
    }

    /**
     * Test getBoard returns 3x3 grid.
     */
    public function testGetBoardReturns3x3Grid(): void
    {
        $response = $this->ticTacHandler->getBoard('game-123');

        $data = json_decode($response->getContent(), true);
        $this->assertCount(3, $data['board']);
        foreach ($data['board'] as $row) {
            $this->assertCount(3, $row);
        }
    }

    /**
     * Test getBoard current turn is X or O.
     */
    public function testGetBoardCurrentTurnIsXorO(): void
    {
        $response = $this->ticTacHandler->getBoard('game-123');

        $data = json_decode($response->getContent(), true);
        $this->assertContains($data['currentTurn'], ['X', 'O']);
    }

    /**
     * Test getGame returns 200 with game data via GameplayHandler.
     */
    public function testGetGameReturns200WithGameData(): void
    {
        $response = $this->gameplayHandler->getGame('game-123');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('mode', $data);
        $this->assertEquals('game-123', $data['id']);
    }

    /**
     * Test getSquare returns 200 with square data.
     */
    public function testGetSquareReturns200WithSquareData(): void
    {
        $response = $this->gameplayHandler->getSquare('game-123', 0, 0);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('row', $data);
        $this->assertArrayHasKey('column', $data);
        $this->assertArrayHasKey('mark', $data);
    }

    /**
     * Test getSquare returns correct coordinates.
     */
    public function testGetSquareReturnsCorrectCoordinates(): void
    {
        $response = $this->gameplayHandler->getSquare('game-123', 1, 2);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(1, $data['row']);
        $this->assertEquals(2, $data['column']);
    }

    /**
     * Test getSquare returns X mark at position 0,0.
     */
    public function testGetSquareReturnsXMarkAtPosition00(): void
    {
        $response = $this->gameplayHandler->getSquare('game-123', 0, 0);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('X', $data['mark']);
    }

    /**
     * Test getSquare returns O mark at position 0,2.
     */
    public function testGetSquareReturnsOMarkAtPosition02(): void
    {
        $response = $this->gameplayHandler->getSquare('game-123', 0, 2);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('O', $data['mark']);
    }

    /**
     * Test getSquare returns null for empty square.
     */
    public function testGetSquareReturnsNullForEmptySquare(): void
    {
        $response = $this->gameplayHandler->getSquare('game-123', 0, 1);

        $data = json_decode($response->getContent(), true);
        $this->assertNull($data['mark']);
    }

    /**
     * Test putSquare returns 200 with updated board.
     */
    public function testPutSquareReturns200WithUpdatedBoard(): void
    {
        $moveRequest = new MoveRequest('X');

        $response = $this->gameplayHandler->putSquare('game-123', 2, 2, $moveRequest);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('gameId', $data);
        $this->assertArrayHasKey('board', $data);
        $this->assertArrayHasKey('currentTurn', $data);
        $this->assertArrayHasKey('move', $data);
    }

    /**
     * Test putSquare changes current turn after X plays.
     */
    public function testPutSquareChangesCurrentTurnAfterXPlays(): void
    {
        $moveRequest = new MoveRequest('X');

        $response = $this->gameplayHandler->putSquare('game-123', 0, 1, $moveRequest);

        $data = json_decode($response->getContent(), true);
        // After X plays, it should be O's turn
        $this->assertEquals('O', $data['currentTurn']);
    }

    /**
     * Test putSquare changes current turn after O plays.
     */
    public function testPutSquareChangesCurrentTurnAfterOPlays(): void
    {
        $moveRequest = new MoveRequest('O');

        $response = $this->gameplayHandler->putSquare('game-123', 0, 1, $moveRequest);

        $data = json_decode($response->getContent(), true);
        // After O plays, it should be X's turn
        $this->assertEquals('X', $data['currentTurn']);
    }

    /**
     * Test putSquare detects winner on diagonal.
     */
    public function testPutSquareDetectsWinnerOnDiagonal(): void
    {
        $moveRequest = new MoveRequest('X');

        // The handler has hardcoded logic: row=2, col=2, mark=X triggers diagonal win
        $response = $this->gameplayHandler->putSquare('game-123', 2, 2, $moveRequest);

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('winner', $data);
        $this->assertEquals('X', $data['winner']);
    }

    /**
     * Test putSquare includes move details in response.
     */
    public function testPutSquareIncludesMoveDetails(): void
    {
        $moveRequest = new MoveRequest('X');

        $response = $this->gameplayHandler->putSquare('game-123', 1, 1, $moveRequest);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(1, $data['move']['row']);
        $this->assertEquals(1, $data['move']['column']);
        $this->assertEquals('X', $data['move']['mark']);
    }

    /**
     * Test getMoves returns 200 with move history.
     */
    public function testGetMovesReturns200WithMoveHistory(): void
    {
        $response = $this->gameplayHandler->getMoves('game-123');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('gameId', $data);
        $this->assertArrayHasKey('moves', $data);
        $this->assertIsArray($data['moves']);
    }

    /**
     * Test getMoves returns correct game ID.
     */
    public function testGetMovesReturnsCorrectGameId(): void
    {
        $response = $this->gameplayHandler->getMoves('my-game-id');

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('my-game-id', $data['gameId']);
    }

    /**
     * Test getMoves returns moves with required fields.
     */
    public function testGetMovesReturnsMovesWithRequiredFields(): void
    {
        $response = $this->gameplayHandler->getMoves('game-123');

        $data = json_decode($response->getContent(), true);
        $this->assertNotEmpty($data['moves']);

        $move = $data['moves'][0];
        $this->assertArrayHasKey('moveNumber', $move);
        $this->assertArrayHasKey('playerId', $move);
        $this->assertArrayHasKey('mark', $move);
        $this->assertArrayHasKey('row', $move);
        $this->assertArrayHasKey('column', $move);
        $this->assertArrayHasKey('timestamp', $move);
    }

    /**
     * Test getMoves returns moves in order.
     */
    public function testGetMovesReturnsMovesInOrder(): void
    {
        $response = $this->gameplayHandler->getMoves('game-123');

        $data = json_decode($response->getContent(), true);

        $lastMoveNumber = 0;
        foreach ($data['moves'] as $move) {
            $this->assertGreaterThan($lastMoveNumber, $move['moveNumber']);
            $lastMoveNumber = $move['moveNumber'];
        }
    }

    /**
     * Test getMoves alternates between X and O marks.
     */
    public function testGetMovesAlternatesBetweenMarks(): void
    {
        $response = $this->gameplayHandler->getMoves('game-123');

        $data = json_decode($response->getContent(), true);
        $this->assertGreaterThanOrEqual(2, count($data['moves']));

        // First move should be X, second should be O
        $this->assertEquals('X', $data['moves'][0]['mark']);
        $this->assertEquals('O', $data['moves'][1]['mark']);
    }
}
