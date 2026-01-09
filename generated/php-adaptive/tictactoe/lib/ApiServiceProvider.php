<?php

declare(strict_types=1);

namespace TicTacToeApi;

use Illuminate\Support\ServiceProvider;

/**
 * Tic Tac Toe Service Provider
 *
 * Register this provider in config/app.php or use Laravel's package auto-discovery.
 *
 * For auto-discovery, add to composer.json:
 * ```json
 * "extra": {
 *     "laravel": {
 *         "providers": [
 *             "TicTacToeApi\\ApiServiceProvider"
 *         ]
 *     }
 * }
 * ```
 */
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * Bind your handler implementations here:
     *
     * ```php
     * public function register(): void
     * {
     *     $this->registerHandlerBindings();
     *
     *     // Override with your implementations:
     *     // $this->app->bind(\TicTacToeApi\Api\GameManagementHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\TicTacToeApi\Api\GameplayHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\TicTacToeApi\Api\StatisticsHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\TicTacToeApi\Api\TicTacHandlerInterface::class, YourHandler::class);
     * }
     * ```
     */
    public function register(): void
    {
        $this->registerHandlerBindings();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
    }

    /**
     * Register default handler interface bindings.
     *
     * By default, interfaces are not bound to any implementation.
     * You must bind your own implementations in your application's AppServiceProvider
     * or override this method.
     *
     * Example in your AppServiceProvider:
     * ```php
     * $this->app->bind(\TicTacToeApi\Api\GameManagementHandlerInterface::class, \App\Handlers\GameManagementHandler::class);
     * $this->app->bind(\TicTacToeApi\Api\GameplayHandlerInterface::class, \App\Handlers\GameplayHandler::class);
     * $this->app->bind(\TicTacToeApi\Api\StatisticsHandlerInterface::class, \App\Handlers\StatisticsHandler::class);
     * $this->app->bind(\TicTacToeApi\Api\TicTacHandlerInterface::class, \App\Handlers\TicTacHandler::class);
     * ```
     */
    protected function registerHandlerBindings(): void
    {
        // Handler interfaces available for binding:
        // - \TicTacToeApi\Api\GameManagementHandlerInterface::class
        // - \TicTacToeApi\Api\GameplayHandlerInterface::class
        // - \TicTacToeApi\Api\StatisticsHandlerInterface::class
        // - \TicTacToeApi\Api\TicTacHandlerInterface::class

        // No default bindings - implement handlers in your application
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array<int, class-string>
     */
    public function provides(): array
    {
        return [
            \TicTacToeApi\Api\GameManagementHandlerInterface::class,
            \TicTacToeApi\Api\GameplayHandlerInterface::class,
            \TicTacToeApi\Api\StatisticsHandlerInterface::class,
            \TicTacToeApi\Api\TicTacHandlerInterface::class,
        ];
    }
}
