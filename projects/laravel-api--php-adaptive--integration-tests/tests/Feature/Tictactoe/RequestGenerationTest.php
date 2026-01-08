<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Http\FormRequest;
use TicTacToeApi\Http\Requests\CreateGameRequest;
use TicTacToeApi\Http\Requests\DeleteGameRequest;
use TicTacToeApi\Http\Requests\GetBoardRequest;
use TicTacToeApi\Http\Requests\GetGameRequest;
use TicTacToeApi\Http\Requests\GetLeaderboardRequest;
use TicTacToeApi\Http\Requests\GetMovesRequest;
use TicTacToeApi\Http\Requests\GetPlayerStatsRequest;
use TicTacToeApi\Http\Requests\GetSquareRequest;
use TicTacToeApi\Http\Requests\ListGamesRequest;
use TicTacToeApi\Http\Requests\PutSquareRequest;

/**
 * Tests that verify the generated request classes behave correctly.
 */
class RequestGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string<FormRequest>> Request classes to test
     */
    private array $expectedRequests = [
        'CreateGame' => CreateGameRequest::class,
        'DeleteGame' => DeleteGameRequest::class,
        'GetBoard' => GetBoardRequest::class,
        'GetGame' => GetGameRequest::class,
        'GetLeaderboard' => GetLeaderboardRequest::class,
        'GetMoves' => GetMovesRequest::class,
        'GetPlayerStats' => GetPlayerStatsRequest::class,
        'GetSquare' => GetSquareRequest::class,
        'ListGames' => ListGamesRequest::class,
        'PutSquare' => PutSquareRequest::class,
    ];

    /**
     * Test that all expected request classes exist.
     */
    public function testAllRequestClassesExist(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Request class {$name} should exist"
            );
        }
    }

    /**
     * Test that all request classes extend FormRequest.
     */
    public function testAllRequestsExtendFormRequest(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $request = new $class();
            $this->assertInstanceOf(
                FormRequest::class,
                $request,
                "{$name}Request should extend FormRequest"
            );
        }
    }

    /**
     * Test that all request classes have authorize method returning bool.
     */
    public function testAllRequestsHaveAuthorizeMethod(): void
    {
        // Test specific request classes to verify authorize() behavior
        $this->assertIsBool((new CreateGameRequest())->authorize());
        $this->assertIsBool((new DeleteGameRequest())->authorize());
        $this->assertIsBool((new GetBoardRequest())->authorize());
        $this->assertIsBool((new GetGameRequest())->authorize());
        $this->assertIsBool((new GetLeaderboardRequest())->authorize());
        $this->assertIsBool((new GetMovesRequest())->authorize());
        $this->assertIsBool((new GetPlayerStatsRequest())->authorize());
        $this->assertIsBool((new GetSquareRequest())->authorize());
        $this->assertIsBool((new ListGamesRequest())->authorize());
        $this->assertIsBool((new PutSquareRequest())->authorize());
    }

    /**
     * Test that all request classes have rules method returning array.
     */
    public function testAllRequestsHaveRulesMethod(): void
    {
        // Test specific request classes to verify rules() behavior
        $this->assertIsArray((new CreateGameRequest())->rules());
        $this->assertIsArray((new DeleteGameRequest())->rules());
        $this->assertIsArray((new GetBoardRequest())->rules());
        $this->assertIsArray((new GetGameRequest())->rules());
        $this->assertIsArray((new GetLeaderboardRequest())->rules());
        $this->assertIsArray((new GetMovesRequest())->rules());
        $this->assertIsArray((new GetPlayerStatsRequest())->rules());
        $this->assertIsArray((new GetSquareRequest())->rules());
        $this->assertIsArray((new ListGamesRequest())->rules());
        $this->assertIsArray((new PutSquareRequest())->rules());
    }

    /**
     * Test CreateGameRequest has correct validation rules.
     */
    public function testCreateGameRequestRules(): void
    {
        $request = new CreateGameRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('mode', $rules);
        $this->assertContains('required', $rules['mode']);
    }

    /**
     * Test ListGamesRequest has correct validation rules.
     */
    public function testListGamesRequestRules(): void
    {
        $request = new ListGamesRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('page', $rules);
        $this->assertArrayHasKey('limit', $rules);
        $this->assertContains('nullable', $rules['page']);
        $this->assertContains('integer', $rules['page']);
    }

    /**
     * Test PutSquareRequest has body validation rules.
     */
    public function testPutSquareRequestRules(): void
    {
        $request = new PutSquareRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('mark', $rules);
        $this->assertContains('required', $rules['mark']);
    }

    /**
     * Test that authorize returns true by default.
     */
    public function testAuthorizeReturnsTrue(): void
    {
        $this->assertTrue((new CreateGameRequest())->authorize(), 'CreateGameRequest::authorize() should return true');
        $this->assertTrue((new DeleteGameRequest())->authorize(), 'DeleteGameRequest::authorize() should return true');
        $this->assertTrue((new GetBoardRequest())->authorize(), 'GetBoardRequest::authorize() should return true');
        $this->assertTrue((new GetGameRequest())->authorize(), 'GetGameRequest::authorize() should return true');
        $this->assertTrue((new GetLeaderboardRequest())->authorize(), 'GetLeaderboardRequest::authorize() should return true');
        $this->assertTrue((new GetMovesRequest())->authorize(), 'GetMovesRequest::authorize() should return true');
        $this->assertTrue((new GetPlayerStatsRequest())->authorize(), 'GetPlayerStatsRequest::authorize() should return true');
        $this->assertTrue((new GetSquareRequest())->authorize(), 'GetSquareRequest::authorize() should return true');
        $this->assertTrue((new ListGamesRequest())->authorize(), 'ListGamesRequest::authorize() should return true');
        $this->assertTrue((new PutSquareRequest())->authorize(), 'PutSquareRequest::authorize() should return true');
    }

    /**
     * Test GetLeaderboardRequest has query parameter rules.
     */
    public function testGetLeaderboardRequestRules(): void
    {
        $request = new GetLeaderboardRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('timeframe', $rules);
        $this->assertArrayHasKey('limit', $rules);
    }
}
