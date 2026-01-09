<?php

declare(strict_types=1);

namespace PetshopApi\Providers;

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
        //     \PetshopApi\Api\AdminApiHandlerInterface::class,
        //     \App\Handlers\AdminApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\AnalyticsApiHandlerInterface::class,
        //     \App\Handlers\AnalyticsApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\CreationApiHandlerInterface::class,
        //     \App\Handlers\CreationApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\DetailsApiHandlerInterface::class,
        //     \App\Handlers\DetailsApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\InventoryApiHandlerInterface::class,
        //     \App\Handlers\InventoryApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\ManagementApiHandlerInterface::class,
        //     \App\Handlers\ManagementApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\PetsApiHandlerInterface::class,
        //     \App\Handlers\PetsApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\PublicApiHandlerInterface::class,
        //     \App\Handlers\PublicApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\ReportingApiHandlerInterface::class,
        //     \App\Handlers\ReportingApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\RetrievalApiHandlerInterface::class,
        //     \App\Handlers\RetrievalApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\SearchApiHandlerInterface::class,
        //     \App\Handlers\SearchApiHandler::class
        // );
        // $this->app->bind(
        //     \PetshopApi\Api\WorkflowApiHandlerInterface::class,
        //     \App\Handlers\WorkflowApiHandler::class
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
