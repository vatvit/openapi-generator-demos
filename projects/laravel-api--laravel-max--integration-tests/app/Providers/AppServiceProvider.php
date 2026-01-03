<?php

declare(strict_types=1);

namespace App\Providers;

use App\Handlers\GameManagementHandler;
use App\Handlers\GameplayHandler;
use App\Handlers\StatisticsHandler;
use App\Handlers\TicTacHandler;
use App\Handlers\Petshop\PetsHandler;
use Illuminate\Support\ServiceProvider;
use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use TictactoeApi\Api\Handlers\StatisticsApiHandlerInterface;
use TictactoeApi\Api\Handlers\TicTacApiHandlerInterface;
use PetshopApi\Api\Handlers\PetsApiHandlerInterface;
use PetshopApi\Api\Handlers\RetrievalApiHandlerInterface;
use PetshopApi\Api\Handlers\SearchApiHandlerInterface;
use PetshopApi\Api\Handlers\WorkflowApiHandlerInterface;

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

        // Petshop handlers - PetsHandler implements all 4 interfaces used by controllers
        $this->app->bind(PetsApiHandlerInterface::class, PetsHandler::class);
        $this->app->bind(RetrievalApiHandlerInterface::class, PetsHandler::class);
        $this->app->bind(SearchApiHandlerInterface::class, PetsHandler::class);
        $this->app->bind(WorkflowApiHandlerInterface::class, PetsHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
