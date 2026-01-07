<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // $this->app->bind(
        //     \TicTacToeApi\Api\GameManagementHandlerInterface::class,
        //     \App\Handlers\GameManagementHandler::class
        // );

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
