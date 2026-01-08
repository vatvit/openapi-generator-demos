<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Illuminate\Http\JsonResponse;
use PetshopApi\Http\Controllers\AddPetController;
use PetshopApi\Http\Controllers\DeletePetController;
use PetshopApi\Http\Controllers\FindPetByIdController;
use PetshopApi\Http\Controllers\FindPetsController;
use PetshopApi\Http\Requests\AddPetRequest;
use PetshopApi\Http\Requests\DeletePetRequest;
use PetshopApi\Http\Requests\FindPetByIdRequest;
use PetshopApi\Http\Requests\FindPetsRequest;
use PetshopApi\Api\PetsHandlerInterface;
use PetshopApi\Api\WorkflowHandlerInterface;
use PetshopApi\Api\RetrievalHandlerInterface;
use PetshopApi\Api\SearchHandlerInterface;

/**
 * Tests that verify the generated controller classes behave correctly.
 */
class ControllerGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Controllers to test
     */
    private array $expectedControllers = [
        'AddPet' => AddPetController::class,
        'DeletePet' => DeletePetController::class,
        'FindPetById' => FindPetByIdController::class,
        'FindPets' => FindPetsController::class,
    ];

    /**
     * Test that all expected controller classes exist.
     */
    public function testAllControllersExist(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Controller {$name} should exist"
            );
        }
    }

    /**
     * Test that all controllers are final.
     */
    public function testAllControllersAreFinal(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isFinal(),
                "{$name}Controller should be final"
            );
        }
    }

    /**
     * Test that all controllers have __invoke method.
     */
    public function testAllControllersHaveInvokeMethod(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $this->assertTrue(
                method_exists($class, '__invoke'),
                "{$name}Controller should have __invoke method"
            );
        }
    }

    /**
     * Test that all controllers have constructor.
     */
    public function testAllControllersHaveConstructor(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertNotNull(
                $reflection->getConstructor(),
                "{$name}Controller should have constructor"
            );
        }
    }

    /**
     * Test that all controllers can be instantiated with handler.
     */
    public function testAllControllersCanBeInstantiated(): void
    {
        // Each controller uses a different handler interface
        $workflowMock = $this->createMock(WorkflowHandlerInterface::class);
        $this->assertInstanceOf(AddPetController::class, new AddPetController($workflowMock));

        $petsMock = $this->createMock(PetsHandlerInterface::class);
        $this->assertInstanceOf(DeletePetController::class, new DeletePetController($petsMock));

        $retrievalMock = $this->createMock(RetrievalHandlerInterface::class);
        $this->assertInstanceOf(FindPetByIdController::class, new FindPetByIdController($retrievalMock));

        $searchMock = $this->createMock(SearchHandlerInterface::class);
        $this->assertInstanceOf(FindPetsController::class, new FindPetsController($searchMock));
    }

    /**
     * Test AddPetController constructor accepts correct handler.
     */
    public function testAddPetControllerConstructor(): void
    {
        $handler = $this->createMock(WorkflowHandlerInterface::class);
        $controller = new AddPetController($handler);
        $this->assertInstanceOf(AddPetController::class, $controller);
    }

    /**
     * Test DeletePetController returns JsonResponse with path parameter.
     */
    public function testDeletePetControllerReturnsJsonResponse(): void
    {
        $handler = $this->createMock(PetsHandlerInterface::class);
        $handler->method('deletePet')
            ->willReturn(new JsonResponse(null, 204));

        $controller = new DeletePetController($handler);
        $request = new DeletePetRequest();

        $response = $controller($request, 123);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test FindPetByIdController returns JsonResponse with path parameter.
     */
    public function testFindPetByIdControllerReturnsJsonResponse(): void
    {
        $handler = $this->createMock(RetrievalHandlerInterface::class);
        $handler->method('findPetById')
            ->willReturn(new JsonResponse(['id' => 1, 'name' => 'Fluffy']));

        $controller = new FindPetByIdController($handler);
        $request = new FindPetByIdRequest();

        $response = $controller($request, 1);
        $this->assertInstanceOf(JsonResponse::class, $response);
    }

    /**
     * Test FindPetsController constructor accepts correct handler.
     */
    public function testFindPetsControllerConstructor(): void
    {
        $handler = $this->createMock(SearchHandlerInterface::class);
        $controller = new FindPetsController($handler);
        $this->assertInstanceOf(FindPetsController::class, $controller);
    }

    /**
     * Test that constructor handler parameter is promoted property.
     */
    public function testConstructorHandlerIsPromoted(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionClass($class);
            $constructor = $reflection->getConstructor();
            $param = $constructor->getParameters()[0];

            $this->assertTrue(
                $param->isPromoted(),
                "{$name}Controller handler should be a promoted property"
            );
        }
    }
}
