<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Model\Pet;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Error;

/**
 * Tests for generated Petshop Model DTOs
 */
class PetModelTest extends TestCase
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

        $expectedProperties = ['name', 'id', 'tag'];

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

        $this->assertTrue(
            $reflection->hasProperty('name'),
            'NewPet should have name property'
        );
    }

    public function test_pet_can_be_instantiated(): void
    {
        $pet = new Pet(name: 'Fluffy', id: 1, tag: 'cat');

        $this->assertEquals('Fluffy', $pet->name);
        $this->assertEquals(1, $pet->id);
        $this->assertEquals('cat', $pet->tag);
    }

    public function test_new_pet_can_be_instantiated(): void
    {
        $newPet = new NewPet(name: 'Buddy', tag: 'dog');

        $this->assertEquals('Buddy', $newPet->name);
        $this->assertEquals('dog', $newPet->tag);
    }

    public function test_new_pet_tag_is_optional(): void
    {
        $newPet = new NewPet(name: 'NoTag');

        $this->assertEquals('NoTag', $newPet->name);
        $this->assertNull($newPet->tag);
    }

    public function test_error_can_be_instantiated(): void
    {
        $error = new Error(code: 404, message: 'Not found');

        $this->assertEquals(404, $error->code);
        $this->assertEquals('Not found', $error->message);
    }

    public function test_pet_has_from_array_method(): void
    {
        $reflection = new \ReflectionClass(Pet::class);

        $this->assertTrue(
            $reflection->hasMethod('fromArray'),
            'Pet should have fromArray static method'
        );

        $method = $reflection->getMethod('fromArray');
        $this->assertTrue($method->isStatic(), 'fromArray should be static');
    }

    public function test_pet_has_to_array_method(): void
    {
        $reflection = new \ReflectionClass(Pet::class);

        $this->assertTrue(
            $reflection->hasMethod('toArray'),
            'Pet should have toArray method'
        );
    }

    public function test_pet_from_array(): void
    {
        $data = ['name' => 'Max', 'id' => 5, 'tag' => 'dog'];
        $pet = Pet::fromArray($data);

        $this->assertEquals('Max', $pet->name);
        $this->assertEquals(5, $pet->id);
        $this->assertEquals('dog', $pet->tag);
    }

    public function test_pet_to_array(): void
    {
        $pet = new Pet(name: 'Luna', id: 10, tag: 'cat');
        $array = $pet->toArray();

        // Verify array contents (assertIsArray redundant - toArray() return type is array)
        $this->assertEquals('Luna', $array['name']);
        $this->assertEquals(10, $array['id']);
        $this->assertEquals('cat', $array['tag']);
    }
}
