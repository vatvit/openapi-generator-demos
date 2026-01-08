<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe\Integration;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\GameMode;
use TicTacToeApi\Model\GameStatus;
use App\Handlers\Tictactoe\GameManagementHandler;
use App\Handlers\Tictactoe\GameplayHandler;

/**
 * Integration tests for TicTacToe GameManagement operations.
 *
 * Tests the handler implementations with real model DTOs.
 */
class GameManagementIntegrationTest extends TestCase
{
    private GameManagementHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->handler = new GameManagementHandler();
    }

    /**
     * Test createGame returns 201 with game data.
     */
    public function testCreateGameReturns201WithGameData(): void
    {
        $request = new CreateGameRequest(GameMode::PVP);

        $response = $this->handler->createGame($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('mode', $data);
        $this->assertArrayHasKey('board', $data);
        $this->assertEquals('pending', $data['status']);
        $this->assertEquals('pvp', $data['mode']);
    }

    /**
     * Test createGame with AI easy mode.
     */
    public function testCreateGameWithAiEasyMode(): void
    {
        $request = new CreateGameRequest(GameMode::AI_EASY);

        $response = $this->handler->createGame($request);

        $this->assertEquals(201, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('ai_easy', $data['mode']);
    }

    /**
     * Test createGame with AI medium mode.
     */
    public function testCreateGameWithAiMediumMode(): void
    {
        $request = new CreateGameRequest(GameMode::AI_MEDIUM);

        $response = $this->handler->createGame($request);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('ai_medium', $data['mode']);
    }

    /**
     * Test createGame with AI hard mode.
     */
    public function testCreateGameWithAiHardMode(): void
    {
        $request = new CreateGameRequest(GameMode::AI_HARD);

        $response = $this->handler->createGame($request);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals('ai_hard', $data['mode']);
    }

    /**
     * Test createGame generates unique game IDs.
     */
    public function testCreateGameGeneratesUniqueIds(): void
    {
        $request = new CreateGameRequest(GameMode::PVP);

        $response1 = $this->handler->createGame($request);
        $response2 = $this->handler->createGame($request);

        $data1 = json_decode($response1->getContent(), true);
        $data2 = json_decode($response2->getContent(), true);

        $this->assertNotEquals($data1['id'], $data2['id']);
    }

    /**
     * Test listGames returns 200 with games array.
     */
    public function testListGamesReturns200WithGamesArray(): void
    {
        $response = $this->handler->listGames();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('games', $data);
        $this->assertArrayHasKey('pagination', $data);
        $this->assertIsArray($data['games']);
    }

    /**
     * Test listGames pagination defaults.
     */
    public function testListGamesPaginationDefaults(): void
    {
        $response = $this->handler->listGames();

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(1, $data['pagination']['page']);
        $this->assertEquals(10, $data['pagination']['limit']);
    }

    /**
     * Test listGames with custom pagination.
     */
    public function testListGamesWithCustomPagination(): void
    {
        $response = $this->handler->listGames(page: 2, limit: 5);

        $data = json_decode($response->getContent(), true);
        $this->assertEquals(2, $data['pagination']['page']);
        $this->assertEquals(5, $data['pagination']['limit']);
    }

    /**
     * Test listGames games have required fields.
     */
    public function testListGamesGamesHaveRequiredFields(): void
    {
        $response = $this->handler->listGames();

        $data = json_decode($response->getContent(), true);
        $this->assertNotEmpty($data['games']);

        $game = $data['games'][0];
        $this->assertArrayHasKey('id', $game);
        $this->assertArrayHasKey('status', $game);
        $this->assertArrayHasKey('mode', $game);
        $this->assertArrayHasKey('board', $game);
    }

    /**
     * Test getGame returns 200 with game details.
     */
    public function testGetGameReturns200WithGameDetails(): void
    {
        $response = $this->handler->getGame('test-game-123');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('status', $data);
        $this->assertArrayHasKey('mode', $data);
        $this->assertArrayHasKey('board', $data);
        $this->assertEquals('test-game-123', $data['id']);
    }

    /**
     * Test getGame returns players info.
     */
    public function testGetGameReturnsPlayersInfo(): void
    {
        $response = $this->handler->getGame('game-123');

        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('playerX', $data);
        $this->assertArrayHasKey('playerO', $data);
        $this->assertArrayHasKey('id', $data['playerX']);
        $this->assertArrayHasKey('username', $data['playerX']);
    }

    /**
     * Test deleteGame returns 204.
     */
    public function testDeleteGameReturns204(): void
    {
        $response = $this->handler->deleteGame('game-to-delete');

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(204, $response->getStatusCode());
    }

    /**
     * Test game board is 3x3 grid.
     */
    public function testGameBoardIs3x3Grid(): void
    {
        $request = new CreateGameRequest(GameMode::PVP);

        $response = $this->handler->createGame($request);

        $data = json_decode($response->getContent(), true);
        $this->assertCount(3, $data['board']);
        foreach ($data['board'] as $row) {
            $this->assertCount(3, $row);
        }
    }

    /**
     * Test new game board is empty.
     */
    public function testNewGameBoardIsEmpty(): void
    {
        $request = new CreateGameRequest(GameMode::PVP);

        $response = $this->handler->createGame($request);

        $data = json_decode($response->getContent(), true);
        foreach ($data['board'] as $row) {
            foreach ($row as $cell) {
                $this->assertNull($cell);
            }
        }
    }
}
