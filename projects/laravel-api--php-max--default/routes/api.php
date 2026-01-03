<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file demonstrates php-max laravel-max generator integration.
|
| The generated routes are included from the central generated/ directory.
|
*/

// Include generated API routes (php-max laravel-max generator)
// Path is /generated in Docker container, or ../../generated locally
$generatedRoutesPath = '/generated/laravel-max/tictactoe/routes/api.php';
if (!file_exists($generatedRoutesPath)) {
    $generatedRoutesPath = base_path('../../generated/laravel-max/tictactoe/routes/api.php');
}

// Generated routes expect $router variable from Route::group
Route::group([], function ($router) use ($generatedRoutesPath) {
    require $generatedRoutesPath;
});
