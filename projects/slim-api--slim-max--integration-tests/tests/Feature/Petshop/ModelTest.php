<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Model\Pet;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Error;

/**
 * Tests for generated Petshop Model DTOs (Slim)
 */
class ModelTest extends TestCase
{
    public function test_pet_model_exists(): void
    {
        $this->assertTrue(
            class_exists(Pet::class),
            'Pet model class should exist'
        );
    }

    public function test_new_pet_model_exists(): void
    {
        $this->assertTrue(
            class_exists(NewPet::class),
            'NewPet model class should exist'
        );
    }

    public function test_error_model_exists(): void
    {
        $this->assertTrue(
            class_exists(Error::class),
            'Error model class should exist'
        );
    }

    public function test_pet_has_required_properties(): void
    {
        $reflection = new \ReflectionClass(Pet::class);

        $expectedProperties = ['id', 'name', 'tag'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Pet should have property: $property"
            );
        }
    }

    public function test_new_pet_has_required_properties(): void
    {
        $reflection = new \ReflectionClass(NewPet::class);

        $expectedProperties = ['name', 'tag'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "NewPet should have property: $property"
            );
        }
    }

    public function test_error_has_required_properties(): void
    {
        $reflection = new \ReflectionClass(Error::class);

        $expectedProperties = ['code', 'message'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Error should have property: $property"
            );
        }
    }
}
