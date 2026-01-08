<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// TicTacToe handler interfaces
use TicTacToeApi\Api\GameManagementHandlerInterface;
use TicTacToeApi\Api\GameplayHandlerInterface;
use TicTacToeApi\Api\StatisticsHandlerInterface;
use TicTacToeApi\Api\TicTacHandlerInterface;

// TicTacToe handler implementations
use App\Handlers\Tictactoe\GameManagementHandler;
use App\Handlers\Tictactoe\GameplayHandler;
use App\Handlers\Tictactoe\StatisticsHandler;
use App\Handlers\Tictactoe\TicTacHandler;

// Petshop handler interfaces
use PetshopApi\Api\AdminHandlerInterface;
use PetshopApi\Api\AnalyticsHandlerInterface;
use PetshopApi\Api\CreationHandlerInterface;
use PetshopApi\Api\DetailsHandlerInterface;
use PetshopApi\Api\InventoryHandlerInterface;
use PetshopApi\Api\ManagementHandlerInterface;
use PetshopApi\Api\PetsHandlerInterface;
use PetshopApi\Api\PublicHandlerInterface;
use PetshopApi\Api\ReportingHandlerInterface;
use PetshopApi\Api\RetrievalHandlerInterface;
use PetshopApi\Api\SearchHandlerInterface;
use PetshopApi\Api\WorkflowHandlerInterface;

// Petshop handler implementations
use App\Handlers\Petshop\AdminHandler;
use App\Handlers\Petshop\AnalyticsHandler;
use App\Handlers\Petshop\CreationHandler;
use App\Handlers\Petshop\DetailsHandler;
use App\Handlers\Petshop\InventoryHandler;
use App\Handlers\Petshop\ManagementHandler;
use App\Handlers\Petshop\PetsHandler;
use App\Handlers\Petshop\PublicHandler;
use App\Handlers\Petshop\ReportingHandler;
use App\Handlers\Petshop\RetrievalHandler;
use App\Handlers\Petshop\SearchHandler;
use App\Handlers\Petshop\WorkflowHandler;

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
        $this->app->bind(GameManagementHandlerInterface::class, GameManagementHandler::class);
        $this->app->bind(GameplayHandlerInterface::class, GameplayHandler::class);
        $this->app->bind(StatisticsHandlerInterface::class, StatisticsHandler::class);
        $this->app->bind(TicTacHandlerInterface::class, TicTacHandler::class);

        // Petshop API handler bindings
        $this->app->bind(AdminHandlerInterface::class, AdminHandler::class);
        $this->app->bind(AnalyticsHandlerInterface::class, AnalyticsHandler::class);
        $this->app->bind(CreationHandlerInterface::class, CreationHandler::class);
        $this->app->bind(DetailsHandlerInterface::class, DetailsHandler::class);
        $this->app->bind(InventoryHandlerInterface::class, InventoryHandler::class);
        $this->app->bind(ManagementHandlerInterface::class, ManagementHandler::class);
        $this->app->bind(PetsHandlerInterface::class, PetsHandler::class);
        $this->app->bind(PublicHandlerInterface::class, PublicHandler::class);
        $this->app->bind(ReportingHandlerInterface::class, ReportingHandler::class);
        $this->app->bind(RetrievalHandlerInterface::class, RetrievalHandler::class);
        $this->app->bind(SearchHandlerInterface::class, SearchHandler::class);
        $this->app->bind(WorkflowHandlerInterface::class, WorkflowHandler::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
