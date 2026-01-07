<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;

/**
 * Tests that verify the generated routes.php file has correct structure.
 */
class RoutesGenerationTest extends TestCase
{
    private string $routesPath;
    private string $routesContent;

    protected function setUp(): void
    {
        parent::setUp();
        // Path works both locally and in Docker container
        $this->routesPath = dirname(__DIR__, 3) . '/../../generated/php-adaptive/petshop/lib/routes.php';
        if (file_exists($this->routesPath)) {
            $this->routesContent = file_get_contents($this->routesPath);
        } else {
            $this->routesContent = '';
        }
    }

    /**
     * Test that routes.php file exists.
     */
    public function testRoutesFileExists(): void
    {
        $this->assertFileExists($this->routesPath);
    }

    /**
     * Test that routes.php has no syntax errors.
     */
    public function testRoutesFileHasNoSyntaxErrors(): void
    {
        $output = shell_exec('php -l ' . escapeshellarg($this->routesPath) . ' 2>&1');
        $this->assertStringContainsString('No syntax errors', $output);
    }

    /**
     * Test that routes.php uses strict types.
     */
    public function testRoutesFileUsesStrictTypes(): void
    {
        $this->assertStringContainsString('declare(strict_types=1);', $this->routesContent);
    }

    /**
     * Test that routes.php imports Route facade.
     */
    public function testRoutesFileImportsRouteFacade(): void
    {
        $this->assertStringContainsString('use Illuminate\Support\Facades\Route;', $this->routesContent);
    }

    /**
     * Test addPet route is defined.
     */
    public function testAddPetRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['POST'], '/pets'", $this->routesContent);
        $this->assertStringContainsString('AddPetController::class', $this->routesContent);
        $this->assertStringContainsString("->name('addPet')", $this->routesContent);
    }

    /**
     * Test deletePet route is defined.
     */
    public function testDeletePetRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['DELETE'], '/pets/{id}'", $this->routesContent);
        $this->assertStringContainsString('DeletePetController::class', $this->routesContent);
        $this->assertStringContainsString("->name('deletePet')", $this->routesContent);
    }

    /**
     * Test findPetById route is defined.
     */
    public function testFindPetByIdRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/pets/{id}'", $this->routesContent);
        $this->assertStringContainsString('FindPetByIdController::class', $this->routesContent);
        $this->assertStringContainsString("->name('findPetById')", $this->routesContent);
    }

    /**
     * Test findPets route is defined.
     */
    public function testFindPetsRouteExists(): void
    {
        $this->assertStringContainsString("Route::match(['GET'], '/pets'", $this->routesContent);
        $this->assertStringContainsString('FindPetsController::class', $this->routesContent);
        $this->assertStringContainsString("->name('findPets')", $this->routesContent);
    }

    /**
     * Test routes file has tag section comments.
     */
    public function testRoutesFileHasTagSectionComments(): void
    {
        $this->assertStringContainsString('// Pets Routes', $this->routesContent);
        $this->assertStringContainsString('// Management Routes', $this->routesContent);
    }

    /**
     * Test all controllers use fully qualified namespace.
     */
    public function testControllersUseFullyQualifiedNamespace(): void
    {
        $this->assertStringContainsString('\PetshopApi\Http\Controllers\\', $this->routesContent);
    }
}
