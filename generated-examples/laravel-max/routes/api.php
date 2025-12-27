<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Middleware\AuthenticateGame;

/**
 * Game Management API Routes
 *
 * Auto-generated from OpenAPI specification
 * All routes are automatically registered by Laravel
 */

// POST /api/games - Create a new game
Route::post('/games', [GameController::class, 'createGame'])
    ->name('api.createGame')
    ->middleware(['api', AuthenticateGame::class]);

// GET /api/games/{gameId} - Get game details
Route::get('/games/{gameId}', [GameController::class, 'getGame'])
    ->name('api.getGame')
    ->middleware(['api', AuthenticateGame::class]);
