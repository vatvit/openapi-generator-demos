<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Handler\AddPetApiHandlerInterface;
use PetshopApi\Handler\FindPetByIdApiHandlerInterface;
use PetshopApi\Handler\FindPetsApiHandlerInterface;
use PetshopApi\Handler\DeletePetApiHandlerInterface;

/**
 * Tests for generated Petshop Handler Interfaces (Symfony)
 */
class HandlerInterfaceTest extends TestCase
{
    public function test_add_pet_handler_interface_exists(): void
    {
        $this->assertTrue(
            interface_exists(AddPetApiHandlerInterface::class),
            'AddPetApiHandlerInterface interface should exist'
        );
    }

    public function test_find_pet_by_id_handler_interface_exists(): void
    {
        $this->assertTrue(
            interface_exists(FindPetByIdApiHandlerInterface::class),
            'FindPetByIdApiHandlerInterface interface should exist'
        );
    }

    public function test_find_pets_handler_interface_exists(): void
    {
        $this->assertTrue(
            interface_exists(FindPetsApiHandlerInterface::class),
            'FindPetsApiHandlerInterface interface should exist'
        );
    }

    public function test_delete_pet_handler_interface_exists(): void
    {
        $this->assertTrue(
            interface_exists(DeletePetApiHandlerInterface::class),
            'DeletePetApiHandlerInterface interface should exist'
        );
    }

    public function test_add_pet_handler_has_add_pet_method(): void
    {
        $reflection = new \ReflectionClass(AddPetApiHandlerInterface::class);

        $this->assertTrue(
            $reflection->hasMethod('addPet'),
            'AddPetApiHandlerInterface should have addPet method'
        );

        $method = $reflection->getMethod('addPet');
        $this->assertTrue($method->isPublic(), 'addPet should be public');
    }

    public function test_find_pet_by_id_handler_has_find_pet_by_id_method(): void
    {
        $reflection = new \ReflectionClass(FindPetByIdApiHandlerInterface::class);

        $this->assertTrue(
            $reflection->hasMethod('findPetById'),
            'FindPetByIdApiHandlerInterface should have findPetById method'
        );

        $method = $reflection->getMethod('findPetById');
        $this->assertTrue($method->isPublic(), 'findPetById should be public');
    }

    public function test_find_pets_handler_has_find_pets_method(): void
    {
        $reflection = new \ReflectionClass(FindPetsApiHandlerInterface::class);

        $this->assertTrue(
            $reflection->hasMethod('findPets'),
            'FindPetsApiHandlerInterface should have findPets method'
        );

        $method = $reflection->getMethod('findPets');
        $this->assertTrue($method->isPublic(), 'findPets should be public');
    }

    public function test_delete_pet_handler_has_delete_pet_method(): void
    {
        $reflection = new \ReflectionClass(DeletePetApiHandlerInterface::class);

        $this->assertTrue(
            $reflection->hasMethod('deletePet'),
            'DeletePetApiHandlerInterface should have deletePet method'
        );

        $method = $reflection->getMethod('deletePet');
        $this->assertTrue($method->isPublic(), 'deletePet should be public');
    }

    public function test_find_pet_by_id_method_has_id_parameter(): void
    {
        $reflection = new \ReflectionClass(FindPetByIdApiHandlerInterface::class);
        $method = $reflection->getMethod('findPetById');
        $params = $method->getParameters();

        $this->assertNotEmpty($params, 'findPetById should have parameters');

        $hasIdParam = false;
        foreach ($params as $param) {
            if ($param->getName() === 'id') {
                $hasIdParam = true;
                $type = $param->getType();
                $this->assertInstanceOf(\ReflectionNamedType::class, $type);
                $this->assertEquals('int', $type->getName(), 'id parameter should be int');
                break;
            }
        }

        $this->assertTrue($hasIdParam, 'findPetById should have id parameter');
    }
}
