<?php

use Illuminate\Support\Facades\Route;

/**
 * API Routes
 *
 * Include generated API routes from laravel-max library
 */

Route::group(['middleware' => ['api']], function ($router) {
    // Include generated routes from laravel-max library
    // Routes are included WITHOUT prefix to match OpenAPI spec exactly
    require base_path('../../examples/laravel-max/routes/api.php');
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now()->toISOString(),
    ]);
});
