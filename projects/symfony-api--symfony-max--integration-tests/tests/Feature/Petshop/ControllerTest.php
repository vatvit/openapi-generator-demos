<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Controller\AddPetController;
use PetshopApi\Controller\FindPetByIdController;
use PetshopApi\Controller\FindPetsController;
use PetshopApi\Controller\DeletePetController;
use PetshopApi\Handler\AddPetApiHandlerInterface;
use PetshopApi\Handler\FindPetByIdApiHandlerInterface;
use PetshopApi\Handler\FindPetsApiHandlerInterface;
use PetshopApi\Handler\DeletePetApiHandlerInterface;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Tests for generated Petshop Controllers (Symfony)
 */
class ControllerTest extends TestCase
{
    public function test_add_pet_controller_exists(): void
    {
        $this->assertTrue(
            class_exists(AddPetController::class),
            'AddPetController class should exist'
        );
    }

    public function test_find_pet_by_id_controller_exists(): void
    {
        $this->assertTrue(
            class_exists(FindPetByIdController::class),
            'FindPetByIdController class should exist'
        );
    }

    public function test_find_pets_controller_exists(): void
    {
        $this->assertTrue(
            class_exists(FindPetsController::class),
            'FindPetsController class should exist'
        );
    }

    public function test_delete_pet_controller_exists(): void
    {
        $this->assertTrue(
            class_exists(DeletePetController::class),
            'DeletePetController class should exist'
        );
    }

    public function test_add_pet_controller_has_route_attribute(): void
    {
        $reflection = new \ReflectionClass(AddPetController::class);
        $attributes = $reflection->getAttributes(Route::class);

        $this->assertNotEmpty($attributes, 'AddPetController should have Route attribute');

        $routeAttribute = $attributes[0]->newInstance();
        // Symfony 7 uses public properties instead of getter methods
        $this->assertEquals('/pets', $routeAttribute->path);
        $this->assertContains('POST', $routeAttribute->methods);
    }

    public function test_find_pet_by_id_controller_has_route_attribute(): void
    {
        $reflection = new \ReflectionClass(FindPetByIdController::class);
        $attributes = $reflection->getAttributes(Route::class);

        $this->assertNotEmpty($attributes, 'FindPetByIdController should have Route attribute');

        $routeAttribute = $attributes[0]->newInstance();
        // Symfony 7 uses public properties instead of getter methods
        $this->assertContains('GET', $routeAttribute->methods);
    }

    public function test_add_pet_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(AddPetController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have constructor');

        $params = $constructor->getParameters();
        $hasHandlerParam = false;

        foreach ($params as $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType && $type->getName() === AddPetApiHandlerInterface::class) {
                $hasHandlerParam = true;
                break;
            }
        }

        $this->assertTrue($hasHandlerParam, 'Controller should depend on AddPetApiHandlerInterface');
    }

    public function test_add_pet_controller_is_invokable(): void
    {
        $reflection = new \ReflectionClass(AddPetController::class);

        $this->assertTrue(
            $reflection->hasMethod('__invoke'),
            'AddPetController should be invokable (have __invoke method)'
        );
    }
}
