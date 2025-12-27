<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Api\Handlers\GameApiHandler;
use Illuminate\Http\Resources\Json\JsonResource;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind generated API interfaces to implementations
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
