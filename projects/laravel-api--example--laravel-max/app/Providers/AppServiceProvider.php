<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelMaxApi\Api\GameApi;
use App\Api\GameApiHandler;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind generated API interface to application implementation
        // Generated Library: GameApi interface (contract)
        // Application: GameApiHandler (business logic)
        $this->app->bind(GameApi::class, GameApiHandler::class);
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
