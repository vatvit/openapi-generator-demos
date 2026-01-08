<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;
use TicTacToeApi\Http\Responses\CreateGameResponse;
use TicTacToeApi\Http\Responses\DeleteGameResponse;
use TicTacToeApi\Http\Responses\GetBoardResponse;
use TicTacToeApi\Http\Responses\GetGameResponse;
use TicTacToeApi\Http\Responses\GetLeaderboardResponse;
use TicTacToeApi\Http\Responses\GetMovesResponse;
use TicTacToeApi\Http\Responses\GetPlayerStatsResponse;
use TicTacToeApi\Http\Responses\GetSquareResponse;
use TicTacToeApi\Http\Responses\ListGamesResponse;
use TicTacToeApi\Http\Responses\PutSquareResponse;

/**
 * Tests that verify the generated response classes behave correctly.
 */
class ResponseGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Response classes to test
     */
    private array $expectedResponses = [
        'CreateGame' => CreateGameResponse::class,
        'DeleteGame' => DeleteGameResponse::class,
        'GetBoard' => GetBoardResponse::class,
        'GetGame' => GetGameResponse::class,
        'GetLeaderboard' => GetLeaderboardResponse::class,
        'GetMoves' => GetMovesResponse::class,
        'GetPlayerStats' => GetPlayerStatsResponse::class,
        'GetSquare' => GetSquareResponse::class,
        'ListGames' => ListGamesResponse::class,
        'PutSquare' => PutSquareResponse::class,
    ];

    /**
     * Test that all expected response classes exist.
     */
    public function testAllResponseClassesExist(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Response class {$name} should exist"
            );
        }
    }

    /**
     * Test that all response classes have toJsonResponse method defined.
     */
    public function testAllResponsesHaveToJsonResponseMethod(): void
    {
        // toJsonResponse() requires Laravel container, so we only verify method exists
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'toJsonResponse'),
                "{$name}Response should have toJsonResponse method"
            );
        }
    }

    /**
     * Test that all response classes have ok static factory method.
     */
    public function testAllResponsesHaveOkMethod(): void
    {
        // If ok() was not static/public, these calls would fail
        $this->assertInstanceOf(CreateGameResponse::class, CreateGameResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(DeleteGameResponse::class, DeleteGameResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(GetBoardResponse::class, GetBoardResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(GetGameResponse::class, GetGameResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(GetLeaderboardResponse::class, GetLeaderboardResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(GetMovesResponse::class, GetMovesResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(GetPlayerStatsResponse::class, GetPlayerStatsResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(GetSquareResponse::class, GetSquareResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(ListGamesResponse::class, ListGamesResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(PutSquareResponse::class, PutSquareResponse::ok(['test' => 'data']));
    }

    /**
     * Test that all response classes have created static factory method.
     */
    public function testAllResponsesHaveCreatedMethod(): void
    {
        // If created() was not static/public, these calls would fail
        $this->assertInstanceOf(CreateGameResponse::class, CreateGameResponse::created(['test' => 'data']));
        $this->assertInstanceOf(DeleteGameResponse::class, DeleteGameResponse::created(['test' => 'data']));
        $this->assertInstanceOf(GetBoardResponse::class, GetBoardResponse::created(['test' => 'data']));
        $this->assertInstanceOf(GetGameResponse::class, GetGameResponse::created(['test' => 'data']));
        $this->assertInstanceOf(GetLeaderboardResponse::class, GetLeaderboardResponse::created(['test' => 'data']));
        $this->assertInstanceOf(GetMovesResponse::class, GetMovesResponse::created(['test' => 'data']));
        $this->assertInstanceOf(GetPlayerStatsResponse::class, GetPlayerStatsResponse::created(['test' => 'data']));
        $this->assertInstanceOf(GetSquareResponse::class, GetSquareResponse::created(['test' => 'data']));
        $this->assertInstanceOf(ListGamesResponse::class, ListGamesResponse::created(['test' => 'data']));
        $this->assertInstanceOf(PutSquareResponse::class, PutSquareResponse::created(['test' => 'data']));
    }

    /**
     * Test that all response classes have noContent static factory method.
     */
    public function testAllResponsesHaveNoContentMethod(): void
    {
        // If noContent() was not static/public, these calls would fail
        $this->assertInstanceOf(CreateGameResponse::class, CreateGameResponse::noContent());
        $this->assertInstanceOf(DeleteGameResponse::class, DeleteGameResponse::noContent());
        $this->assertInstanceOf(GetBoardResponse::class, GetBoardResponse::noContent());
        $this->assertInstanceOf(GetGameResponse::class, GetGameResponse::noContent());
        $this->assertInstanceOf(GetLeaderboardResponse::class, GetLeaderboardResponse::noContent());
        $this->assertInstanceOf(GetMovesResponse::class, GetMovesResponse::noContent());
        $this->assertInstanceOf(GetPlayerStatsResponse::class, GetPlayerStatsResponse::noContent());
        $this->assertInstanceOf(GetSquareResponse::class, GetSquareResponse::noContent());
        $this->assertInstanceOf(ListGamesResponse::class, ListGamesResponse::noContent());
        $this->assertInstanceOf(PutSquareResponse::class, PutSquareResponse::noContent());
    }

    /**
     * Test that all response classes have error static factory method.
     */
    public function testAllResponsesHaveErrorMethod(): void
    {
        // If error() was not static/public, these calls would fail
        $this->assertInstanceOf(CreateGameResponse::class, CreateGameResponse::error('Error', 400));
        $this->assertInstanceOf(DeleteGameResponse::class, DeleteGameResponse::error('Error', 400));
        $this->assertInstanceOf(GetBoardResponse::class, GetBoardResponse::error('Error', 400));
        $this->assertInstanceOf(GetGameResponse::class, GetGameResponse::error('Error', 400));
        $this->assertInstanceOf(GetLeaderboardResponse::class, GetLeaderboardResponse::error('Error', 400));
        $this->assertInstanceOf(GetMovesResponse::class, GetMovesResponse::error('Error', 400));
        $this->assertInstanceOf(GetPlayerStatsResponse::class, GetPlayerStatsResponse::error('Error', 400));
        $this->assertInstanceOf(GetSquareResponse::class, GetSquareResponse::error('Error', 400));
        $this->assertInstanceOf(ListGamesResponse::class, ListGamesResponse::error('Error', 400));
        $this->assertInstanceOf(PutSquareResponse::class, PutSquareResponse::error('Error', 400));
    }

    /**
     * Test that all response classes have getData method.
     */
    public function testAllResponsesHaveGetDataMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'getData'),
                "{$name}Response should have getData method"
            );
        }
    }

    /**
     * Test that all response classes have getStatusCode method returning int.
     */
    public function testAllResponsesHaveGetStatusCodeMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $response = $class::ok(['test' => 'data']);
            $statusCode = $response->getStatusCode();
            $this->assertIsInt(
                $statusCode,
                "{$name}Response::getStatusCode() should return int"
            );
        }
    }

    /**
     * Test ok factory method returns correct status code.
     */
    public function testOkReturnsCorrectStatusCode(): void
    {
        $response = CreateGameResponse::ok(['test' => 'data']);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * Test created factory method returns correct status code.
     */
    public function testCreatedReturnsCorrectStatusCode(): void
    {
        $response = CreateGameResponse::created(['test' => 'data']);
        $this->assertSame(201, $response->getStatusCode());
    }

    /**
     * Test noContent factory method returns correct status code.
     */
    public function testNoContentReturnsCorrectStatusCode(): void
    {
        $response = CreateGameResponse::noContent();
        $this->assertSame(204, $response->getStatusCode());
        $this->assertNull($response->getData());
    }

    /**
     * Test error factory method returns correct structure.
     */
    public function testErrorReturnsCorrectStructure(): void
    {
        $response = CreateGameResponse::error('Something went wrong', 400);
        $this->assertSame(400, $response->getStatusCode());

        $data = $response->getData();
        $this->assertIsArray($data);
        $this->assertArrayHasKey('message', $data);
        $this->assertSame('Something went wrong', $data['message']);
    }

    /**
     * Test getData returns the data passed to factory.
     */
    public function testGetDataReturnsCorrectData(): void
    {
        $testData = ['id' => '123', 'status' => 'active'];
        $response = GetGameResponse::ok($testData);

        $this->assertSame($testData, $response->getData());
    }

    /**
     * Test response preserves status code.
     */
    public function testResponsePreservesStatusCode(): void
    {
        // toJsonResponse requires Laravel container, so we test getStatusCode() directly
        $response = CreateGameResponse::created(['id' => '123']);
        $this->assertSame(201, $response->getStatusCode());
    }
}
