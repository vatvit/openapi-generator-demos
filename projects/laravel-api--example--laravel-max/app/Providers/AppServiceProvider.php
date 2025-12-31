<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Resources\Json\JsonResource;

// Per-tag Handler Interfaces
use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use TictactoeApi\Api\Handlers\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Handlers\TicTacApiHandlerInterface;

// Handler Implementation
use App\Api\TictactoeApiHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind all generated per-tag API interfaces to unified handler implementation
        $this->app->bind(GameManagementApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(GameplayApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(StatisticsApiHandlerInterface::class, TictactoeApiHandler::class);
        $this->app->bind(TicTacApiHandlerInterface::class, TictactoeApiHandler::class);
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
