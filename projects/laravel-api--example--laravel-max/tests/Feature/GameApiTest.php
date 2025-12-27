<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Route;

class GameApiTest extends BaseTestCase
{
    /**
     * Creates the application.
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../../bootstrap/app.php';

        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Test that routes are registered correctly
     */
    public function test_routes_are_registered(): void
    {
        $routes = collect(Route::getRoutes())->map(fn($route) => $route->getName())->filter();

        $this->assertTrue($routes->contains('api.createGame'), 'api.createGame route not registered');
        $this->assertTrue($routes->contains('api.getGame'), 'api.getGame route not registered');
    }

    /**
     * Test createGame endpoint returns 201 with Location header
     */
    public function test_create_game_returns_201_with_location_header(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'two-player',
            'playerXId' => 'player1',
            'playerOId' => 'player2',
        ]);

        $response->assertStatus(201);
        $response->assertHeader('Location');
        $response->assertJsonStructure([
            'id',
            'status',
            'mode',
            'playerXId',
            'playerOId',
            'currentTurn',
            'winner',
            'createdAt',
            'updatedAt',
        ]);
        $response->assertJson([
            'status' => 'waiting',
            'mode' => 'two-player',
            'playerXId' => 'player1',
            'playerOId' => 'player2',
            'currentTurn' => 'X',
        ]);
    }

    /**
     * Test createGame validates required fields
     */
    public function test_create_game_validates_required_fields(): void
    {
        $response = $this->postJson('/games', []);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'error',
            'message',
            'errors',
        ]);
        $response->assertJson([
            'error' => 'Validation Error',
        ]);
    }

    /**
     * Test createGame validates mode enum
     */
    public function test_create_game_validates_mode_enum(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'invalid-mode',
            'playerXId' => 'player1',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.mode', fn($errors) => count($errors) > 0);
    }

    /**
     * Test createGame validates playerOId required for two-player mode
     */
    public function test_create_game_requires_player_o_for_two_player_mode(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'two-player',
            'playerXId' => 'player1',
            // playerOId missing
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.playerOId', fn($errors) => count($errors) > 0);
    }

    /**
     * Test createGame allows single-player without playerOId
     */
    public function test_create_game_allows_single_player_without_player_o(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'single-player',
            'playerXId' => 'player1',
        ]);

        $response->assertStatus(201);
        $response->assertJsonPath('playerOId', null);
    }

    /**
     * Test getGame endpoint returns 200
     */
    public function test_get_game_returns_200(): void
    {
        $response = $this->getJson('/games/test-game-123');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'status',
            'mode',
            'playerXId',
            'playerOId',
            'currentTurn',
            'winner',
            'createdAt',
            'updatedAt',
        ]);
        $response->assertJson([
            'id' => 'test-game-123',
        ]);
    }

    /**
     * Test getGame does NOT have Location header
     */
    public function test_get_game_has_no_location_header(): void
    {
        $response = $this->getJson('/games/test-game-123');

        $response->assertStatus(200);
        $response->assertHeaderMissing('Location');
    }

    /**
     * Test Location header points to correct route
     */
    public function test_create_game_location_header_points_to_get_game(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'single-player',
            'playerXId' => 'player1',
        ]);

        $response->assertStatus(201);

        $gameId = $response->json('id');
        $locationHeader = $response->headers->get('Location');

        // Location should point to the getGame route
        $this->assertStringContainsString("/games/{$gameId}", $locationHeader);
    }

    /**
     * Test health check endpoint
     */
    public function test_health_check_endpoint(): void
    {
        $response = $this->getJson('/health');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'status',
            'timestamp',
        ]);
        $response->assertJson([
            'status' => 'healthy',
        ]);
    }

    /**
     * Test getGame returns 422 for game not found
     */
    public function test_get_game_returns_422_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-123');

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'error',
            'message',
            'errors',
        ]);
        $response->assertJson([
            'error' => 'Validation Error',
            'message' => 'Game not found',
        ]);
        $response->assertJsonPath('errors.gameId', fn($errors) => count($errors) > 0);
    }

    /**
     * Test getGame returns 422 for invalid game ID
     */
    public function test_get_game_returns_422_for_invalid_id(): void
    {
        $response = $this->getJson('/games/ab');

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'error',
            'message',
            'errors',
        ]);
        $response->assertJson([
            'error' => 'Validation Error',
            'message' => 'Invalid game ID',
        ]);
        $response->assertJsonPath('errors.gameId', fn($errors) => count($errors) > 0);
    }
}
