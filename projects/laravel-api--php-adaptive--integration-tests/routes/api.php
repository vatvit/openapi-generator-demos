<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Routes will be registered here once the generated libraries are integrated.
| See the generated routes.php files in:
| - ../../generated/php-adaptive/tictactoe/lib/routes.php
| - ../../generated/php-adaptive/petshop/lib/routes.php
|
*/

Route::get('/', function () {
    return response()->json([
        'name' => 'PHP-Adaptive Integration Tests',
        'status' => 'ready',
    ]);
});
