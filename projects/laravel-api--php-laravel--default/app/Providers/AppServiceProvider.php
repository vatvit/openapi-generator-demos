<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// TicTacToe API interfaces
use TicTacToeApi\Api\GameManagementApiInterface;
use TicTacToeApi\Api\GameplayApiInterface;
use TicTacToeApi\Api\StatisticsApiInterface;
use TicTacToeApi\Api\TicTacApiInterface;

// Handler implementations
use App\Api\TicTacToe\GameManagementHandler;
use App\Api\TicTacToe\GameplayHandler;
use App\Api\TicTacToe\StatisticsHandler;
use App\Api\TicTacToe\TicTacHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Binds generated API interfaces to handler implementations.
     * This is how the OOTB php-laravel generator expects integration.
     */
    public function register(): void
    {
        // TicTacToe API handlers
        $this->app->bind(GameManagementApiInterface::class, GameManagementHandler::class);
        $this->app->bind(GameplayApiInterface::class, GameplayHandler::class);
        $this->app->bind(StatisticsApiInterface::class, StatisticsHandler::class);
        $this->app->bind(TicTacApiInterface::class, TicTacHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
