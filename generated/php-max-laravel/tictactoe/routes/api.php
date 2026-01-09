<?php

declare(strict_types=1);

/**
 * API Routes
 *
 * Generated from OpenAPI specification.
 * Include this file from your Laravel routes/api.php within a Route::group.
 *
 * Usage:
 * ```php
 * Route::group(['prefix' => 'v1', 'middleware' => ['api']], function ($router) {
 *     require base_path('path/to/generated/routes/api.php');
 * });
 * ```
 *
 * @generated
 */

use Illuminate\Support\Facades\Route;

/**
 * POST /games
 * Create a new game
 *
 * Creates a new TicTacToe game with specified configuration.
 *
 * Security: bearerHttpAuthentication
 */
Route::post('/games', \TictactoeApi\Api\Http\Controllers\CreateGameController::class)
    ->name('api.createGame');

/**
 * DELETE /games/{gameId}
 * Delete a game
 *
 * Deletes a game. Only allowed for game creators or admins.
 *
 * Security: bearerHttpAuthentication
 */
Route::delete('/games/{gameId}', \TictactoeApi\Api\Http\Controllers\DeleteGameController::class)
    ->name('api.deleteGame');

/**
 * GET /games/{gameId}
 * Get game details
 *
 * Retrieves detailed information about a specific game.
 *
 * Security: bearerHttpAuthentication
 */
Route::get('/games/{gameId}', \TictactoeApi\Api\Http\Controllers\GetGameController::class)
    ->name('api.getGame');

/**
 * GET /games
 * List all games
 *
 * Retrieves a paginated list of games with optional filtering.
 *
 * Security: bearerHttpAuthentication
 */
Route::get('/games', \TictactoeApi\Api\Http\Controllers\ListGamesController::class)
    ->name('api.listGames');

/**
 * GET /games/{gameId}/board
 * Get the game board
 *
 * Retrieves the current state of the board and the winner.
 *
 * Security: defaultApiKey, app2AppOauth
 */
Route::get('/games/{gameId}/board', \TictactoeApi\Api\Http\Controllers\GetBoardController::class)
    ->name('api.getBoard');

/**
 * GET /games/{gameId}/moves
 * Get move history
 *
 * Retrieves the complete move history for a game.
 *
 * Security: bearerHttpAuthentication
 */
Route::get('/games/{gameId}/moves', \TictactoeApi\Api\Http\Controllers\GetMovesController::class)
    ->name('api.getMoves');

/**
 * GET /games/{gameId}/board/{row}/{column}
 * Get a single board square
 *
 * Retrieves the requested square.
 *
 * Security: bearerHttpAuthentication, user2AppOauth
 */
Route::get('/games/{gameId}/board/{row}/{column}', \TictactoeApi\Api\Http\Controllers\GetSquareController::class)
    ->name('api.getSquare');

/**
 * PUT /games/{gameId}/board/{row}/{column}
 * Set a single board square
 *
 * Places a mark on the board and retrieves the whole board and the winner (if any).
 *
 * Security: bearerHttpAuthentication, user2AppOauth
 */
Route::put('/games/{gameId}/board/{row}/{column}', \TictactoeApi\Api\Http\Controllers\PutSquareController::class)
    ->name('api.putSquare');

/**
 * GET /leaderboard
 * Get leaderboard
 *
 * Retrieves the global leaderboard with top players.
 *
 */
Route::get('/leaderboard', \TictactoeApi\Api\Http\Controllers\GetLeaderboardController::class)
    ->name('api.getLeaderboard');

/**
 * GET /players/{playerId}/stats
 * Get player statistics
 *
 * Retrieves comprehensive statistics for a player.
 *
 * Security: bearerHttpAuthentication
 */
Route::get('/players/{playerId}/stats', \TictactoeApi\Api\Http\Controllers\GetPlayerStatsController::class)
    ->name('api.getPlayerStats');

