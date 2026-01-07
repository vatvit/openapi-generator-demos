<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Http\JsonResponse;
use PetshopApi\Http\Controllers\AddPetController;
use PetshopApi\Http\Controllers\DeletePetController;
use PetshopApi\Http\Controllers\FindPetByIdController;
use PetshopApi\Http\Controllers\FindPetsController;
use PetshopApi\Http\Requests\AddPetRequest;
use PetshopApi\Http\Requests\FindPetByIdRequest;

/**
 * Tests that verify the generated controller classes have correct structure.
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
     * Test that all __invoke methods return JsonResponse.
     */
    public function testAllInvokeMethodsReturnJsonResponse(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionMethod($class, '__invoke');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame(
                JsonResponse::class,
                $returnType->getName(),
                "{$name}Controller::__invoke should return JsonResponse"
            );
        }
    }

    /**
     * Test that constructor injects handler interface.
     */
    public function testConstructorInjectsHandlerInterface(): void
    {
        foreach ($this->expectedControllers as $name => $class) {
            $reflection = new ReflectionClass($class);
            $constructor = $reflection->getConstructor();
            $params = $constructor->getParameters();

            $this->assertCount(1, $params, "{$name}Controller should have 1 constructor parameter");
            $this->assertSame('handler', $params[0]->getName());

            // Handler type should end with 'HandlerInterface'
            $handlerType = $params[0]->getType()->getName();
            $this->assertStringEndsWith(
                'HandlerInterface',
                $handlerType,
                "{$name}Controller should inject a HandlerInterface"
            );
        }
    }

    /**
     * Test AddPetController __invoke has request parameter.
     */
    public function testAddPetControllerInvokeHasRequestParameter(): void
    {
        $reflection = new ReflectionMethod(AddPetController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertGreaterThanOrEqual(1, count($params));
        $this->assertSame('request', $params[0]->getName());
        $this->assertSame(
            AddPetRequest::class,
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test FindPetByIdController __invoke has path parameter.
     */
    public function testFindPetByIdControllerInvokeHasPathParameter(): void
    {
        $reflection = new ReflectionMethod(FindPetByIdController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertCount(2, $params);
        $this->assertSame('request', $params[0]->getName());
        $this->assertSame('id', $params[1]->getName());
        $this->assertSame('int', $params[1]->getType()->getName());
    }

    /**
     * Test DeletePetController __invoke has path parameter.
     */
    public function testDeletePetControllerInvokeHasPathParameter(): void
    {
        $reflection = new ReflectionMethod(DeletePetController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertCount(2, $params);
        $this->assertSame('id', $params[1]->getName());
        $this->assertSame('int', $params[1]->getType()->getName());
    }

    /**
     * Test FindPetsController __invoke has only request parameter (query params in request).
     */
    public function testFindPetsControllerInvokeHasOnlyRequestParameter(): void
    {
        $reflection = new ReflectionMethod(FindPetsController::class, '__invoke');
        $params = $reflection->getParameters();

        $this->assertCount(1, $params);
        $this->assertSame('request', $params[0]->getName());
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
