<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

// Per-operation Handler Interfaces
use TictactoeApi\Api\Handlers\CreateGameApiHandlerInterface;
use TictactoeApi\Api\Handlers\DeleteGameApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetBoardApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetGameApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetLeaderboardApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetMovesApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetPlayerStatsApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetSquareApiHandlerInterface;
use TictactoeApi\Api\Handlers\ListGamesApiHandlerInterface;
use TictactoeApi\Api\Handlers\PutSquareApiHandlerInterface;

// Handler Implementation
use App\Api\TictactoeApiHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind all generated per-operation API interfaces to unified handler implementation
        $this->app->bind(CreateGameApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(DeleteGameApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GetBoardApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GetGameApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GetLeaderboardApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GetMovesApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GetPlayerStatsApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GetSquareApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(ListGamesApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(PutSquareApiHandlerInterface::class, TictactoeApiHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Disable data wrapping for API resources
        // This ensures JSON responses match OpenAPI schema exactly
        JsonResource::withoutWrapping();
    }
}
