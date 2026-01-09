<?php

declare(strict_types=1);

namespace PetshopApi;

use Illuminate\Support\ServiceProvider;

/**
 * PetStoreApiController Service Provider
 *
 * Register this provider in config/app.php or use Laravel's package auto-discovery.
 *
 * For auto-discovery, add to composer.json:
 * ```json
 * "extra": {
 *     "laravel": {
 *         "providers": [
 *             "PetshopApi\\ApiServiceProvider"
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
     *     // $this->app->bind(\PetshopApi\Api\AdminHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\AnalyticsHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\CreationHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\DetailsHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\InventoryHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\ManagementHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\PetsHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\PublicHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\ReportingHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\RetrievalHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\SearchHandlerInterface::class, YourHandler::class);
     *     // $this->app->bind(\PetshopApi\Api\WorkflowHandlerInterface::class, YourHandler::class);
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
     * $this->app->bind(\PetshopApi\Api\AdminHandlerInterface::class, \App\Handlers\AdminHandler::class);
     * $this->app->bind(\PetshopApi\Api\AnalyticsHandlerInterface::class, \App\Handlers\AnalyticsHandler::class);
     * $this->app->bind(\PetshopApi\Api\CreationHandlerInterface::class, \App\Handlers\CreationHandler::class);
     * $this->app->bind(\PetshopApi\Api\DetailsHandlerInterface::class, \App\Handlers\DetailsHandler::class);
     * $this->app->bind(\PetshopApi\Api\InventoryHandlerInterface::class, \App\Handlers\InventoryHandler::class);
     * $this->app->bind(\PetshopApi\Api\ManagementHandlerInterface::class, \App\Handlers\ManagementHandler::class);
     * $this->app->bind(\PetshopApi\Api\PetsHandlerInterface::class, \App\Handlers\PetsHandler::class);
     * $this->app->bind(\PetshopApi\Api\PublicHandlerInterface::class, \App\Handlers\PublicHandler::class);
     * $this->app->bind(\PetshopApi\Api\ReportingHandlerInterface::class, \App\Handlers\ReportingHandler::class);
     * $this->app->bind(\PetshopApi\Api\RetrievalHandlerInterface::class, \App\Handlers\RetrievalHandler::class);
     * $this->app->bind(\PetshopApi\Api\SearchHandlerInterface::class, \App\Handlers\SearchHandler::class);
     * $this->app->bind(\PetshopApi\Api\WorkflowHandlerInterface::class, \App\Handlers\WorkflowHandler::class);
     * ```
     */
    protected function registerHandlerBindings(): void
    {
        // Handler interfaces available for binding:
        // - \PetshopApi\Api\AdminHandlerInterface::class
        // - \PetshopApi\Api\AnalyticsHandlerInterface::class
        // - \PetshopApi\Api\CreationHandlerInterface::class
        // - \PetshopApi\Api\DetailsHandlerInterface::class
        // - \PetshopApi\Api\InventoryHandlerInterface::class
        // - \PetshopApi\Api\ManagementHandlerInterface::class
        // - \PetshopApi\Api\PetsHandlerInterface::class
        // - \PetshopApi\Api\PublicHandlerInterface::class
        // - \PetshopApi\Api\ReportingHandlerInterface::class
        // - \PetshopApi\Api\RetrievalHandlerInterface::class
        // - \PetshopApi\Api\SearchHandlerInterface::class
        // - \PetshopApi\Api\WorkflowHandlerInterface::class

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
            \PetshopApi\Api\AdminHandlerInterface::class,
            \PetshopApi\Api\AnalyticsHandlerInterface::class,
            \PetshopApi\Api\CreationHandlerInterface::class,
            \PetshopApi\Api\DetailsHandlerInterface::class,
            \PetshopApi\Api\InventoryHandlerInterface::class,
            \PetshopApi\Api\ManagementHandlerInterface::class,
            \PetshopApi\Api\PetsHandlerInterface::class,
            \PetshopApi\Api\PublicHandlerInterface::class,
            \PetshopApi\Api\ReportingHandlerInterface::class,
            \PetshopApi\Api\RetrievalHandlerInterface::class,
            \PetshopApi\Api\SearchHandlerInterface::class,
            \PetshopApi\Api\WorkflowHandlerInterface::class,
        ];
    }
}
