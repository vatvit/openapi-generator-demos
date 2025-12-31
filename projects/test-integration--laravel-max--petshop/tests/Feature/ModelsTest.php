<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Model\Pet;
use TictactoeApi\Model\NewPet;
use TictactoeApi\Model\Error;

/**
 * Tests for generated Model DTOs
 *
 * Validates that the generator produces proper PHP DTOs
 */
class ModelsTest extends TestCase
{
    public function test_pet_model_exists(): void
    {
        $this->assertTrue(class_exists(Pet::class), 'Pet model should exist');
    }

    public function test_new_pet_model_exists(): void
    {
        $this->assertTrue(class_exists(NewPet::class), 'NewPet model should exist');
    }

    public function test_error_model_exists(): void
    {
        $this->assertTrue(class_exists(Error::class), 'Error model should exist');
    }

    public function test_pet_has_required_properties(): void
    {
        $reflection = new ReflectionClass(Pet::class);

        $this->assertTrue($reflection->hasProperty('id'), 'Pet should have id property');
        $this->assertTrue($reflection->hasProperty('name'), 'Pet should have name property');
        $this->assertTrue($reflection->hasProperty('tag'), 'Pet should have tag property');
    }

    public function test_new_pet_has_required_properties(): void
    {
        $reflection = new ReflectionClass(NewPet::class);

        $this->assertTrue($reflection->hasProperty('name'), 'NewPet should have name property');
        $this->assertTrue($reflection->hasProperty('tag'), 'NewPet should have tag property');
    }

    public function test_pet_has_from_array_method(): void
    {
        $reflection = new ReflectionClass(Pet::class);
        $this->assertTrue($reflection->hasMethod('fromArray'), 'Pet should have fromArray() method');
    }

    public function test_pet_has_to_array_method(): void
    {
        $reflection = new ReflectionClass(Pet::class);
        $this->assertTrue($reflection->hasMethod('toArray'), 'Pet should have toArray() method');
    }

    public function test_pet_from_array_creates_instance(): void
    {
        $data = [
            'id' => 1,
            'name' => 'Fido',
            'tag' => 'dog',
        ];

        $pet = Pet::fromArray($data);

        $this->assertInstanceOf(Pet::class, $pet);
        $this->assertEquals(1, $pet->id);
        $this->assertEquals('Fido', $pet->name);
        $this->assertEquals('dog', $pet->tag);
    }

    public function test_pet_to_array_returns_data(): void
    {
        $pet = new Pet(
            id: 1,
            name: 'Fido',
            tag: 'dog'
        );

        $array = $pet->toArray();

        $this->assertIsArray($array);
        $this->assertEquals(1, $array['id']);
        $this->assertEquals('Fido', $array['name']);
        $this->assertEquals('dog', $array['tag']);
    }

    public function test_constructor_parameter_order(): void
    {
        // Required parameters should come before optional ones
        $reflection = new ReflectionClass(Pet::class);
        $constructor = $reflection->getConstructor();
        $params = $constructor->getParameters();

        $foundOptional = false;
        foreach ($params as $param) {
            if ($param->isOptional()) {
                $foundOptional = true;
            } else {
                // Required param found - should not be after optional
                $this->assertFalse($foundOptional,
                    'Required parameters should come before optional parameters in constructor');
            }
        }
    }
}
