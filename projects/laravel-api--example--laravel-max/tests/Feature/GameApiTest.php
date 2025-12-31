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

    // =========================================================================
    // Route Registration Tests
    // =========================================================================

    public function test_routes_are_registered(): void
    {
        $routes = collect(Route::getRoutes())->map(fn($route) => $route->getName())->filter();

        $this->assertTrue($routes->contains('api.createGame'), 'api.createGame route not registered');
        $this->assertTrue($routes->contains('api.getGame'), 'api.getGame route not registered');
        $this->assertTrue($routes->contains('api.listGames'), 'api.listGames route not registered');
        $this->assertTrue($routes->contains('api.deleteGame'), 'api.deleteGame route not registered');
    }

    // =========================================================================
    // Create Game Tests
    // =========================================================================

    public function test_create_game_returns_201_with_location_header(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'pvp',  // Valid enum value: pvp, ai_easy, ai_medium, ai_hard
        ]);

        $response->assertStatus(201);
        $response->assertHeader('Location');
        $response->assertJsonStructure([
            'id',
            'status',
            'mode',
            'board',
            'createdAt',
        ]);
    }

    public function test_create_game_validates_required_mode(): void
    {
        $response = $this->postJson('/games', []);

        // Laravel returns 422 for validation errors
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors',
        ]);
    }

    public function test_create_game_validates_mode_enum(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'invalid-mode',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.mode.0', 'The selected mode is invalid.');
    }

    public function test_create_game_with_ai_mode(): void
    {
        $response = $this->postJson('/games', [
            'mode' => 'ai_easy',
        ]);

        $response->assertStatus(201);
    }

    // =========================================================================
    // Get Game Tests
    // =========================================================================

    public function test_get_game_returns_200(): void
    {
        $response = $this->getJson('/games/test-game-123');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'status',
            'mode',
            'board',
            'createdAt',
        ]);
        $response->assertJson([
            'id' => 'test-game-123',
        ]);
    }

    public function test_get_game_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-game');

        $response->assertStatus(404);
    }

    // =========================================================================
    // Delete Game Tests
    // =========================================================================

    public function test_delete_game_returns_204(): void
    {
        $response = $this->deleteJson('/games/test-game-123');

        $response->assertStatus(204);
    }

    public function test_delete_game_returns_404_for_not_found(): void
    {
        $response = $this->deleteJson('/games/notfound-game');

        $response->assertStatus(404);
    }

    public function test_delete_game_returns_403_for_forbidden(): void
    {
        $response = $this->deleteJson('/games/forbidden-game');

        $response->assertStatus(403);
    }

    // =========================================================================
    // List Games Tests
    // =========================================================================

    public function test_list_games_returns_200(): void
    {
        $response = $this->getJson('/games?page=1&limit=10&timeframe=all');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'games',
            'pagination' => [
                'total',
                'page',
                'limit',
            ],
        ]);
    }

    // =========================================================================
    // Get Board Tests
    // =========================================================================

    public function test_get_board_returns_200(): void
    {
        $response = $this->getJson('/games/test-game-123/board');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'winner',
            'board',
        ]);
    }

    public function test_get_board_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-game/board');

        $response->assertStatus(404);
    }

    // =========================================================================
    // Get Square Tests
    // =========================================================================

    public function test_get_square_returns_200(): void
    {
        $response = $this->getJson('/games/test-game-123/board/1/1');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'row',
            'column',
            'mark',
        ]);
    }

    public function test_get_square_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-game/board/1/1');

        $response->assertStatus(404);
    }

    public function test_get_square_returns_400_for_invalid_coordinates(): void
    {
        $response = $this->getJson('/games/test-game-123/board/0/0');

        $response->assertStatus(400);
    }

    // =========================================================================
    // Put Square Tests
    // =========================================================================

    public function test_put_square_returns_200(): void
    {
        $response = $this->putJson('/games/test-game-123/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'winner',
            'board',
        ]);
    }

    public function test_put_square_returns_404_for_not_found(): void
    {
        $response = $this->putJson('/games/notfound-game/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(404);
    }

    public function test_put_square_returns_409_for_occupied(): void
    {
        $response = $this->putJson('/games/occupied-game/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(409);
    }

    public function test_put_square_returns_409_for_game_finished(): void
    {
        $response = $this->putJson('/games/finished-game/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(409);
    }

    // =========================================================================
    // Get Moves Tests
    // =========================================================================

    public function test_get_moves_returns_200(): void
    {
        $response = $this->getJson('/games/test-game-123/moves');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'gameId',
            'moves',
        ]);
    }

    public function test_get_moves_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-game/moves');

        $response->assertStatus(404);
    }

    // =========================================================================
    // Statistics Tests
    // =========================================================================

    public function test_get_leaderboard_returns_200(): void
    {
        $response = $this->getJson('/leaderboard?timeframe=all&limit=10');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'timeframe',
            'entries',
            'generatedAt',
        ]);
    }

    public function test_get_player_stats_returns_200(): void
    {
        $response = $this->getJson('/players/player-123/stats');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'playerId',
            'gamesPlayed',
            'wins',
            'losses',
            'draws',
            'winRate',
        ]);
    }

    public function test_get_player_stats_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/players/notfound-player/stats');

        $response->assertStatus(404);
    }
}
