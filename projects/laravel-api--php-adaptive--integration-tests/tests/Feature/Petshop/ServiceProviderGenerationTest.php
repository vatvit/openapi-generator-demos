<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;

/**
 * Tests that verify the generated ApiServiceProvider.php has correct structure.
 */
class ServiceProviderGenerationTest extends TestCase
{
    private string $serviceProviderPath;
    private string $serviceProviderContent;
    private string $composerPath;
    private string $composerContent;

    protected function setUp(): void
    {
        parent::setUp();
        // Path works both locally and in Docker container
        $this->serviceProviderPath = dirname(__DIR__, 3) . '/../../generated/php-adaptive/petshop/lib/ApiServiceProvider.php';
        if (file_exists($this->serviceProviderPath)) {
            $this->serviceProviderContent = file_get_contents($this->serviceProviderPath);
        } else {
            $this->serviceProviderContent = '';
        }

        $this->composerPath = dirname(__DIR__, 3) . '/../../generated/php-adaptive/petshop/composer.json';
        if (file_exists($this->composerPath)) {
            $this->composerContent = file_get_contents($this->composerPath);
        } else {
            $this->composerContent = '';
        }
    }

    /**
     * Test that ApiServiceProvider.php file exists.
     */
    public function testServiceProviderFileExists(): void
    {
        $this->assertFileExists($this->serviceProviderPath);
    }

    /**
     * Test that ApiServiceProvider.php has no syntax errors.
     */
    public function testServiceProviderHasNoSyntaxErrors(): void
    {
        $output = shell_exec('php -l ' . escapeshellarg($this->serviceProviderPath) . ' 2>&1');
        $this->assertStringContainsString('No syntax errors', $output);
    }

    /**
     * Test that ApiServiceProvider.php uses strict types.
     */
    public function testServiceProviderUsesStrictTypes(): void
    {
        $this->assertStringContainsString('declare(strict_types=1);', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider.php has correct namespace.
     */
    public function testServiceProviderHasCorrectNamespace(): void
    {
        $this->assertStringContainsString('namespace PetshopApi;', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider extends Laravel ServiceProvider.
     */
    public function testServiceProviderExtendsLaravelServiceProvider(): void
    {
        $this->assertStringContainsString('use Illuminate\Support\ServiceProvider;', $this->serviceProviderContent);
        $this->assertStringContainsString('class ApiServiceProvider extends ServiceProvider', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider has register method.
     */
    public function testServiceProviderHasRegisterMethod(): void
    {
        $this->assertStringContainsString('public function register(): void', $this->serviceProviderContent);
        $this->assertStringContainsString('$this->registerHandlerBindings();', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider has boot method that loads routes.
     */
    public function testServiceProviderHasBootMethodWithRoutes(): void
    {
        $this->assertStringContainsString('public function boot(): void', $this->serviceProviderContent);
        $this->assertStringContainsString("\$this->loadRoutesFrom(__DIR__ . '/routes.php');", $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider has provides method.
     */
    public function testServiceProviderHasProvidesMethod(): void
    {
        $this->assertStringContainsString('public function provides(): array', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists AdminHandlerInterface.
     */
    public function testServiceProviderListsAdminHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\AdminHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists AnalyticsHandlerInterface.
     */
    public function testServiceProviderListsAnalyticsHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\AnalyticsHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists CreationHandlerInterface.
     */
    public function testServiceProviderListsCreationHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\CreationHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists DetailsHandlerInterface.
     */
    public function testServiceProviderListsDetailsHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\DetailsHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists InventoryHandlerInterface.
     */
    public function testServiceProviderListsInventoryHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\InventoryHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists ManagementHandlerInterface.
     */
    public function testServiceProviderListsManagementHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\ManagementHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists PetsHandlerInterface.
     */
    public function testServiceProviderListsPetsHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\PetsHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists PublicHandlerInterface.
     */
    public function testServiceProviderListsPublicHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\PublicHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists ReportingHandlerInterface.
     */
    public function testServiceProviderListsReportingHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\ReportingHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists RetrievalHandlerInterface.
     */
    public function testServiceProviderListsRetrievalHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\RetrievalHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists SearchHandlerInterface.
     */
    public function testServiceProviderListsSearchHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\SearchHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider lists WorkflowHandlerInterface.
     */
    public function testServiceProviderListsWorkflowHandlerInterface(): void
    {
        $this->assertStringContainsString('\PetshopApi\Api\WorkflowHandlerInterface::class', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider has protected registerHandlerBindings method.
     */
    public function testServiceProviderHasRegisterHandlerBindingsMethod(): void
    {
        $this->assertStringContainsString('protected function registerHandlerBindings(): void', $this->serviceProviderContent);
    }

    /**
     * Test that provides() method returns all handler interfaces.
     */
    public function testProvidesMethodReturnsAllHandlerInterfaces(): void
    {
        // Extract provides() method content
        $providesPattern = '/public function provides\(\): array\s*\{[^}]+\}/s';
        preg_match($providesPattern, $this->serviceProviderContent, $matches);
        $providesContent = $matches[0] ?? '';

        $this->assertStringContainsString('AdminHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('AnalyticsHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('CreationHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('DetailsHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('InventoryHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('ManagementHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('PetsHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('PublicHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('ReportingHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('RetrievalHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('SearchHandlerInterface::class', $providesContent);
        $this->assertStringContainsString('WorkflowHandlerInterface::class', $providesContent);
    }

    /**
     * Test that composer.json exists.
     */
    public function testComposerJsonExists(): void
    {
        $this->assertFileExists($this->composerPath);
    }

    /**
     * Test that composer.json has Laravel auto-discovery configuration.
     */
    public function testComposerJsonHasLaravelAutoDiscovery(): void
    {
        $composer = json_decode($this->composerContent, true);
        $this->assertIsArray($composer);
        $this->assertArrayHasKey('extra', $composer);
        $this->assertArrayHasKey('laravel', $composer['extra']);
        $this->assertArrayHasKey('providers', $composer['extra']['laravel']);
        $this->assertContains('PetshopApi\\ApiServiceProvider', $composer['extra']['laravel']['providers']);
    }

    /**
     * Test that composer.json has illuminate/support dependency.
     */
    public function testComposerJsonHasIlluminateSupportDependency(): void
    {
        $composer = json_decode($this->composerContent, true);
        $this->assertIsArray($composer);
        $this->assertArrayHasKey('require', $composer);
        $this->assertArrayHasKey('illuminate/support', $composer['require']);
    }

    /**
     * Test that composer.json has illuminate/http dependency.
     */
    public function testComposerJsonHasIlluminateHttpDependency(): void
    {
        $composer = json_decode($this->composerContent, true);
        $this->assertIsArray($composer);
        $this->assertArrayHasKey('require', $composer);
        $this->assertArrayHasKey('illuminate/http', $composer['require']);
    }

    /**
     * Test that composer.json has illuminate/routing dependency.
     */
    public function testComposerJsonHasIlluminateRoutingDependency(): void
    {
        $composer = json_decode($this->composerContent, true);
        $this->assertIsArray($composer);
        $this->assertArrayHasKey('require', $composer);
        $this->assertArrayHasKey('illuminate/routing', $composer['require']);
    }

    /**
     * Test that composer.json requires PHP 8.1+.
     */
    public function testComposerJsonRequiresPhp81(): void
    {
        $composer = json_decode($this->composerContent, true);
        $this->assertIsArray($composer);
        $this->assertArrayHasKey('require', $composer);
        $this->assertArrayHasKey('php', $composer['require']);
        $this->assertStringContainsString('^8.1', $composer['require']['php']);
    }

    /**
     * Test that ApiServiceProvider has documentation in registerHandlerBindings.
     */
    public function testServiceProviderHasHandlerBindingsDocumentation(): void
    {
        $this->assertStringContainsString('Handler interfaces available for binding:', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider has usage example in class docblock.
     */
    public function testServiceProviderHasUsageExampleInDocblock(): void
    {
        $this->assertStringContainsString('Register this provider in config/app.php', $this->serviceProviderContent);
        $this->assertStringContainsString('For auto-discovery, add to composer.json:', $this->serviceProviderContent);
    }

    /**
     * Test that ApiServiceProvider has binding examples.
     */
    public function testServiceProviderHasBindingExamples(): void
    {
        $this->assertStringContainsString('$this->app->bind(', $this->serviceProviderContent);
    }
}
