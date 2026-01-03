<?php

declare(strict_types=1);

/**
 * Slim Framework Routes
 *
 * Auto-generated from OpenAPI specification.
 * Register these routes with your Slim application.
 *
 * Usage:
 * ```php
 * $app = \Slim\Factory\AppFactory::create();
 * $container = $app->getContainer();
 * (require __DIR__ . '/routes.php')($app, $container);
 * $app->run();
 * ```
 *
 * @generated
 */

use Psr\Container\ContainerInterface;
use Slim\App;

return function (App $app, ContainerInterface $container): void {
    // ============================================================
    // CreateGameApi Routes
    // ============================================================

    /**
     * POST /games
     *
     * Create a new game
     * Creates a new TicTacToe game with specified configuration.
     *
     * Security: bearerHttpAuthentication
     */
    $app->post(
        '/games',
        TicTacToe\Handler\CreateGameHandler::class
    )->setName('createGame');
    // ============================================================
    // DeleteGameApi Routes
    // ============================================================

    /**
     * DELETE /games/{gameId}
     *
     * Delete a game
     * Deletes a game. Only allowed for game creators or admins.
     *
     * Security: bearerHttpAuthentication
     */
    $app->delete(
        '/games/{gameId}',
        TicTacToe\Handler\DeleteGameHandler::class
    )->setName('deleteGame');
    // ============================================================
    // GetBoardApi Routes
    // ============================================================

    /**
     * GET /games/{gameId}/board
     *
     * Get the game board
     * Retrieves the current state of the board and the winner.
     *
     * Security: defaultApiKey, app2AppOauth
     */
    $app->get(
        '/games/{gameId}/board',
        TicTacToe\Handler\GetBoardHandler::class
    )->setName('getBoard');
    // ============================================================
    // GetGameApi Routes
    // ============================================================

    /**
     * GET /games/{gameId}
     *
     * Get game details
     * Retrieves detailed information about a specific game.
     *
     * Security: bearerHttpAuthentication
     */
    $app->get(
        '/games/{gameId}',
        TicTacToe\Handler\GetGameHandler::class
    )->setName('getGame');
    // ============================================================
    // GetLeaderboardApi Routes
    // ============================================================

    /**
     * GET /leaderboard
     *
     * Get leaderboard
     * Retrieves the global leaderboard with top players.
     */
    $app->get(
        '/leaderboard',
        TicTacToe\Handler\GetLeaderboardHandler::class
    )->setName('getLeaderboard');
    // ============================================================
    // GetMovesApi Routes
    // ============================================================

    /**
     * GET /games/{gameId}/moves
     *
     * Get move history
     * Retrieves the complete move history for a game.
     *
     * Security: bearerHttpAuthentication
     */
    $app->get(
        '/games/{gameId}/moves',
        TicTacToe\Handler\GetMovesHandler::class
    )->setName('getMoves');
    // ============================================================
    // GetPlayerStatsApi Routes
    // ============================================================

    /**
     * GET /players/{playerId}/stats
     *
     * Get player statistics
     * Retrieves comprehensive statistics for a player.
     *
     * Security: bearerHttpAuthentication
     */
    $app->get(
        '/players/{playerId}/stats',
        TicTacToe\Handler\GetPlayerStatsHandler::class
    )->setName('getPlayerStats');
    // ============================================================
    // GetSquareApi Routes
    // ============================================================

    /**
     * GET /games/{gameId}/board/{row}/{column}
     *
     * Get a single board square
     * Retrieves the requested square.
     *
     * Security: bearerHttpAuthentication, user2AppOauth
     */
    $app->get(
        '/games/{gameId}/board/{row}/{column}',
        TicTacToe\Handler\GetSquareHandler::class
    )->setName('getSquare');
    // ============================================================
    // ListGamesApi Routes
    // ============================================================

    /**
     * GET /games
     *
     * List all games
     * Retrieves a paginated list of games with optional filtering.
     *
     * Security: bearerHttpAuthentication
     */
    $app->get(
        '/games',
        TicTacToe\Handler\ListGamesHandler::class
    )->setName('listGames');
    // ============================================================
    // PutSquareApi Routes
    // ============================================================

    /**
     * PUT /games/{gameId}/board/{row}/{column}
     *
     * Set a single board square
     * Places a mark on the board and retrieves the whole board and the winner (if any).
     *
     * Security: bearerHttpAuthentication, user2AppOauth
     */
    $app->put(
        '/games/{gameId}/board/{row}/{column}',
        TicTacToe\Handler\PutSquareHandler::class
    )->setName('putSquare');
};
