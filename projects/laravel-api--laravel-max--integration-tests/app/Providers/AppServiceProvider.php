<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Handler interfaces from generated library
use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use TictactoeApi\Api\Handlers\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Handlers\TicTacApiHandlerInterface;

// Handler implementations
use App\Handlers\GameManagementHandler;
use App\Handlers\GameplayHandler;
use App\Handlers\StatisticsHandler;
use App\Handlers\TicTacHandler;

/**
 * Application Service Provider
 *
 * Registers handler interface bindings for dependency injection.
 * This wires the generated library interfaces to our implementations.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind handler interfaces to implementations
        $this->app->bind(GameManagementApiHandlerInterface::class, GameManagementHandler::class);
        $this->app->bind(GameplayApiHandlerInterface::class, GameplayHandler::class);
        $this->app->bind(StatisticsApiHandlerInterface::class, StatisticsHandler::class);
        $this->app->bind(TicTacApiHandlerInterface::class, TicTacHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
