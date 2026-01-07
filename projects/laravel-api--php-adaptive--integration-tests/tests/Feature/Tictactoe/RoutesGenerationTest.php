<?php

declare(strict_types=1);

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;

/**
 * Tests that verify the generated routes.php file has correct structure.
 */
class RoutesGenerationTest extends TestCase
{
    private string $routesPath;
    private string $routesContent;

    protected function setUp(): void
    {
        parent::setUp();
        // Path works both locally and in Docker container
        $this->routesPath = dirname(__DIR__, 3) . '/../../generated/php-adaptive/tictactoe/lib/routes.php';
        if (file_exists($this->routesPath)) {
            $this->routesContent = file_get_contents($this->routesPath);
        } else {
            $this->routesContent = '';
        }
    }

    /**
     * Test that routes.php file exists.
     */
    public function testRoutesFileExists(): void
    {
        $this->assertFileExists($this->routesPath);
    }

    /**
     * Test that routes.php has no syntax errors.
     */
    public function testRoutesFileHasNoSyntaxErrors(): void
    {
        $output = shell_exec('php -l ' . escapeshellarg($this->routesPath) . ' 2>&1');
        $this->assertStringContainsString('No syntax errors', $output);
    }

    /**
     * Test that routes.php uses strict types.
     */
    public function testRoutesFileUsesStrictTypes(): void
    {
        $this->assertStringContainsString('declare(strict_types=1);', $this->routesContent);
    }

    /**
     * Test that routes.php imports Route facade.
     */
    public function testRoutesFileImportsRouteFacade(): void
    {
        $this->assertStringContainsString('use Illuminate\Support\Facades\Route;', $this->routesContent);
    }

    /**
     * Test createGame route is defined.
     */
    public function testCreateGameRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['POST'], '/games'", $this->routesContent);
        $this->assertStringContainsString('CreateGameController::class', $this->routesContent);
        $this->assertStringContainsString("->name('createGame')", $this->routesContent);
    }

    /**
     * Test deleteGame route is defined.
     */
    public function testDeleteGameRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['DELETE'], '/games/{gameId}'", $this->routesContent);
        $this->assertStringContainsString('DeleteGameController::class', $this->routesContent);
        $this->assertStringContainsString("->name('deleteGame')", $this->routesContent);
    }

    /**
     * Test getGame route is defined.
     */
    public function testGetGameRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/games/{gameId}'", $this->routesContent);
        $this->assertStringContainsString('GetGameController::class', $this->routesContent);
        $this->assertStringContainsString("->name('getGame')", $this->routesContent);
    }

    /**
     * Test listGames route is defined.
     */
    public function testListGamesRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/games'", $this->routesContent);
        $this->assertStringContainsString('ListGamesController::class', $this->routesContent);
        $this->assertStringContainsString("->name('listGames')", $this->routesContent);
    }

    /**
     * Test getBoard route is defined.
     */
    public function testGetBoardRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/games/{gameId}/board'", $this->routesContent);
        $this->assertStringContainsString('GetBoardController::class', $this->routesContent);
        $this->assertStringContainsString("->name('getBoard')", $this->routesContent);
    }

    /**
     * Test getMoves route is defined.
     */
    public function testGetMovesRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/games/{gameId}/moves'", $this->routesContent);
        $this->assertStringContainsString('GetMovesController::class', $this->routesContent);
        $this->assertStringContainsString("->name('getMoves')", $this->routesContent);
    }

    /**
     * Test getSquare route is defined.
     */
    public function testGetSquareRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/games/{gameId}/board/{row}/{column}'", $this->routesContent);
        $this->assertStringContainsString('GetSquareController::class', $this->routesContent);
        $this->assertStringContainsString("->name('getSquare')", $this->routesContent);
    }

    /**
     * Test putSquare route is defined.
     */
    public function testPutSquareRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['PUT'], '/games/{gameId}/board/{row}/{column}'", $this->routesContent);
        $this->assertStringContainsString('PutSquareController::class', $this->routesContent);
        $this->assertStringContainsString("->name('putSquare')", $this->routesContent);
    }

    /**
     * Test getLeaderboard route is defined.
     */
    public function testGetLeaderboardRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/leaderboard'", $this->routesContent);
        $this->assertStringContainsString('GetLeaderboardController::class', $this->routesContent);
        $this->assertStringContainsString("->name('getLeaderboard')", $this->routesContent);
    }

    /**
     * Test getPlayerStats route is defined.
     */
    public function testGetPlayerStatsRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/players/{playerId}/stats'", $this->routesContent);
        $this->assertStringContainsString('GetPlayerStatsController::class', $this->routesContent);
        $this->assertStringContainsString("->name('getPlayerStats')", $this->routesContent);
    }

    /**
     * Test routes file has tag section comments.
     */
    public function testRoutesFileHasTagSectionComments(): void
    {
        $this->assertStringContainsString('// GameManagement Routes', $this->routesContent);
        $this->assertStringContainsString('// Gameplay Routes', $this->routesContent);
        $this->assertStringContainsString('// Statistics Routes', $this->routesContent);
    }

    /**
     * Test all controllers use fully qualified namespace.
     */
    public function testControllersUseFullyQualifiedNamespace(): void
    {
        $this->assertStringContainsString('\TicTacToeApi\Http\Controllers\\', $this->routesContent);
    }
}
