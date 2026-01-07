<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
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
 * Tests that verify the generated request classes have correct structure.
 */
class RequestGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Request classes to test
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
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isSubclassOf(FormRequest::class),
                "{$name}Request should extend FormRequest"
            );
        }
    }

    /**
     * Test that all request classes are final.
     */
    public function testAllRequestsAreFinal(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isFinal(),
                "{$name}Request should be final"
            );
        }
    }

    /**
     * Test that all request classes have authorize method.
     */
    public function testAllRequestsHaveAuthorizeMethod(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'authorize'),
                "{$name}Request should have authorize method"
            );

            $reflection = new ReflectionMethod($class, 'authorize');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame('bool', $returnType->getName());
        }
    }

    /**
     * Test that all request classes have rules method.
     */
    public function testAllRequestsHaveRulesMethod(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'rules'),
                "{$name}Request should have rules method"
            );

            $reflection = new ReflectionMethod($class, 'rules');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame('array', $returnType->getName());
        }
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
     * Test that authorize returns true by default.
     */
    public function testAuthorizeReturnsTrue(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $request = new $class();
            $this->assertTrue(
                $request->authorize(),
                "{$name}Request::authorize() should return true"
            );
        }
    }
}
