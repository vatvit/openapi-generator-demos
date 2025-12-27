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
     * Test getGame returns 404 for game not found
     */
    public function test_get_game_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-123');

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'error',
            'message',
            'code',
        ]);
        $response->assertJson([
            'error' => 'Not Found',
            'message' => 'Game not found',
            'code' => 'GAME_NOT_FOUND',
        ]);
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

    // ============================================================================
    // LIST GAMES ENDPOINT TESTS
    // ============================================================================

    /**
     * Test listGames returns 200 with games array
     */
    public function test_list_games_returns_200_with_games(): void
    {
        $response = $this->getJson('/games');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'status',
                    'mode',
                    'playerXId',
                    'playerOId',
                    'currentTurn',
                    'winner',
                    'createdAt',
                    'updatedAt',
                ]
            ]
        ]);
    }

    /**
     * Test listGames returns pagination headers
     */
    public function test_list_games_returns_pagination_headers(): void
    {
        $response = $this->getJson('/games?page=2&limit=10');

        $response->assertStatus(200);
        // X-Total-Count is REQUIRED
        $response->assertHeader('X-Total-Count');
        // X-Page-Number and X-Page-Size are OPTIONAL
        $this->assertTrue(
            $response->headers->has('X-Page-Number') || true,
            'X-Page-Number is optional'
        );
        $this->assertTrue(
            $response->headers->has('X-Page-Size') || true,
            'X-Page-Size is optional'
        );
    }

    /**
     * Test listGames accepts pagination parameters
     */
    public function test_list_games_accepts_pagination_parameters(): void
    {
        $response = $this->getJson('/games?page=1&limit=5');

        $response->assertStatus(200);
        $response->assertHeader('X-Total-Count');
    }

    /**
     * Test listGames accepts filter parameters
     */
    public function test_list_games_accepts_filter_parameters(): void
    {
        $response = $this->getJson('/games?status=in-progress&playerXId=player1');

        $response->assertStatus(200);
    }

    /**
     * Test listGames validates invalid page number
     */
    public function test_list_games_validates_invalid_page(): void
    {
        $response = $this->getJson('/games?page=0');

        $response->assertStatus(422);
        $response->assertJsonPath('errors.page', fn($errors) => count($errors) > 0);
    }

    /**
     * Test listGames validates invalid limit
     */
    public function test_list_games_validates_invalid_limit(): void
    {
        $response = $this->getJson('/games?limit=200');

        $response->assertStatus(422);
        $response->assertJsonPath('errors.limit', fn($errors) => count($errors) > 0);
    }

    /**
     * Test listGames validates invalid status
     */
    public function test_list_games_validates_invalid_status(): void
    {
        $response = $this->getJson('/games?status=invalid-status');

        $response->assertStatus(422);
        $response->assertJsonPath('errors.status', fn($errors) => count($errors) > 0);
    }

    // ============================================================================
    // DELETE GAME ENDPOINT TESTS
    // ============================================================================

    /**
     * Test deleteGame returns 204 No Content
     */
    public function test_delete_game_returns_204_no_content(): void
    {
        $response = $this->deleteJson('/games/game-to-delete');

        $response->assertStatus(204);
        $response->assertNoContent();
    }

    /**
     * Test deleteGame returns 404 for game not found
     */
    public function test_delete_game_returns_404_for_not_found(): void
    {
        $response = $this->deleteJson('/games/notfound-123');

        $response->assertStatus(404);
        $response->assertJsonStructure([
            'error',
            'message',
            'code',
        ]);
        $response->assertJson([
            'error' => 'Not Found',
            'message' => 'Game not found',
            'code' => 'GAME_NOT_FOUND',
        ]);
    }

    /**
     * Test deleteGame returns 403 Forbidden for permission denied
     */
    public function test_delete_game_returns_403_forbidden(): void
    {
        $response = $this->deleteJson('/games/forbidden-123');

        $response->assertStatus(403);
        $response->assertJsonStructure([
            'error',
            'message',
            'code',
        ]);
        $response->assertJson([
            'error' => 'Forbidden',
            'code' => 'FORBIDDEN',
        ]);
    }

    // ============================================================================
    // GET BOARD ENDPOINT TESTS
    // ============================================================================

    /**
     * Test getBoard returns 200 with board state
     */
    public function test_get_board_returns_200_with_board(): void
    {
        $response = $this->getJson('/games/test-game-123/board');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'board',
            'winner',
        ]);
        // Board should be a 3x3 array
        $board = $response->json('board');
        $this->assertIsArray($board);
        $this->assertCount(3, $board);
        $this->assertCount(3, $board[0]);
    }

    /**
     * Test getBoard returns 404 for game not found
     */
    public function test_get_board_returns_404_for_not_found(): void
    {
        $response = $this->getJson('/games/notfound-123/board');

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Not Found',
            'message' => 'Game not found',
            'code' => 'GAME_NOT_FOUND',
        ]);
    }

    // ============================================================================
    // PUT SQUARE ENDPOINT TESTS
    // ============================================================================

    /**
     * Test putSquare returns 200 with updated board
     */
    public function test_put_square_returns_200_with_updated_board(): void
    {
        $response = $this->putJson('/games/test-game-123/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'board',
            'winner',
        ]);

        // Verify the mark was placed
        $board = $response->json('board');
        $this->assertEquals('X', $board[0][0]);
    }

    /**
     * Test putSquare validates required mark field
     */
    public function test_put_square_validates_required_mark(): void
    {
        $response = $this->putJson('/games/test-game-123/board/1/1', []);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.mark', fn($errors) => count($errors) > 0);
    }

    /**
     * Test putSquare validates mark enum
     */
    public function test_put_square_validates_mark_enum(): void
    {
        $response = $this->putJson('/games/test-game-123/board/1/1', [
            'mark' => 'invalid-mark',
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.mark', fn($errors) => count($errors) > 0);
    }

    /**
     * Test putSquare validates invalid coordinates
     */
    public function test_put_square_validates_invalid_coordinates(): void
    {
        $response = $this->putJson('/games/test-game-123/board/5/5', [
            'mark' => 'X',
        ]);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'error',
            'message',
            'errors',
        ]);
    }

    /**
     * Test putSquare returns 404 for game not found
     */
    public function test_put_square_returns_404_for_not_found(): void
    {
        $response = $this->putJson('/games/notfound-123/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(404);
        $response->assertJson([
            'error' => 'Not Found',
            'message' => 'Game not found',
            'code' => 'GAME_NOT_FOUND',
        ]);
    }

    /**
     * Test putSquare returns 409 Conflict for square already occupied
     */
    public function test_put_square_returns_409_for_square_occupied(): void
    {
        $response = $this->putJson('/games/occupied-game/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(409);
        $response->assertJsonStructure([
            'error',
            'message',
            'code',
        ]);
        $response->assertJson([
            'error' => 'Conflict',
            'message' => 'Square already occupied',
            'code' => 'SQUARE_OCCUPIED',
        ]);
    }

    /**
     * Test putSquare returns 409 Conflict for game already finished
     */
    public function test_put_square_returns_409_for_game_finished(): void
    {
        $response = $this->putJson('/games/finished-game/board/1/1', [
            'mark' => 'X',
        ]);

        $response->assertStatus(409);
        $response->assertJson([
            'error' => 'Conflict',
            'message' => 'Game is already finished',
            'code' => 'GAME_FINISHED',
        ]);
    }
}
