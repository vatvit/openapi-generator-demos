<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// TicTacToe handler interfaces
use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Api\TicTacHandlerInterface;

// TicTacToe handler implementations
use App\Handlers\Tictactoe\GameManagementHandler;
use App\Handlers\Tictactoe\GameplayHandler;
use App\Handlers\Tictactoe\StatisticsHandler;
use App\Handlers\Tictactoe\TicTacHandler;

/**
 * Application Service Provider.
 *
 * Registers handler interface bindings for generated APIs.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // TicTacToe API handler bindings
        $this->app->bind(GameManagementHandlerInterface::class, GameManagementHandler::class);
        $this->app->bind(GameplayHandlerInterface::class, GameplayHandler::class);
        $this->app->bind(StatisticsHandlerInterface::class, StatisticsHandler::class);
        $this->app->bind(TicTacHandlerInterface::class, TicTacHandler::class);

        // Petshop API handler bindings
        // $this->app->bind(
        //     \PetshopApi\Api\PetsHandlerInterface::class,
        //     \App\Handlers\PetsHandler::class
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
