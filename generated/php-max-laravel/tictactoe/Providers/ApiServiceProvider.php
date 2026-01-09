<?php

declare(strict_types=1);

namespace TictactoeApi\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * ApiServiceProvider
 *
 * Service provider for the generated API package.
 * Register this provider in your Laravel application's config/app.php.
 *
 * @generated
 */
class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register handler interface bindings
        // Uncomment and configure the implementations in your application:
        //
        // $this->app->bind(
        //     \TictactoeApi\Api\GameManagementApiHandlerInterface::class,
        //     \App\Handlers\GameManagementApiHandler::class
        // );
        // $this->app->bind(
        //     \TictactoeApi\Api\GameplayApiHandlerInterface::class,
        //     \App\Handlers\GameplayApiHandler::class
        // );
        // $this->app->bind(
        //     \TictactoeApi\Api\StatisticsApiHandlerInterface::class,
        //     \App\Handlers\StatisticsApiHandler::class
        // );
        // $this->app->bind(
        //     \TictactoeApi\Api\TicTacApiHandlerInterface::class,
        //     \App\Handlers\TicTacApiHandler::class
        // );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Load API routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
