<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| This file demonstrates OOTB php-laravel generator integration.
|
| Using config files with `controllerPackage` option allows proper
| namespace isolation, enabling multiple APIs in the same project.
|
*/

// Include both generated API routes
// Each API uses its own namespace (configured via controllerPackage)
require base_path('generated/tictactoe/routes.php');
require base_path('generated/petshop/routes.php');
