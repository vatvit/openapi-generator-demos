<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Model\Pet;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Error;

/**
 * Tests that verify the generated Petshop model classes behave correctly.
 */
class ModelGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Models to test for existence
     */
    private array $expectedModels = [
        'Pet' => Pet::class,
        'NewPet' => NewPet::class,
        'Error' => Error::class,
    ];

    /**
     * Test that all expected model classes exist.
     */
    public function testAllModelClassesExist(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Model class {$name} should exist"
            );
        }
    }

    /**
     * Test that Pet model can be created with expected properties.
     */
    public function testPetModelCanBeCreatedWithProperties(): void
    {
        $pet = Pet::fromArray([
            'id' => 1,
            'name' => 'Fluffy',
            'tag' => 'cat',
        ]);

        $this->assertInstanceOf(Pet::class, $pet);
        $array = $pet->toArray();
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('name', $array);
        $this->assertSame(1, $array['id']);
        $this->assertSame('Fluffy', $array['name']);
    }

    /**
     * Test that NewPet model can be created with expected properties.
     */
    public function testNewPetModelCanBeCreatedWithProperties(): void
    {
        $newPet = NewPet::fromArray([
            'name' => 'Buddy',
            'tag' => 'dog',
        ]);

        $this->assertInstanceOf(NewPet::class, $newPet);
        $array = $newPet->toArray();
        $this->assertArrayHasKey('name', $array);
        $this->assertArrayHasKey('tag', $array);
        $this->assertSame('Buddy', $array['name']);
    }

    /**
     * Test that Error model can be created with expected properties.
     */
    public function testErrorModelCanBeCreatedWithProperties(): void
    {
        $error = Error::fromArray([
            'code' => 404,
            'message' => 'Pet not found',
        ]);

        $this->assertInstanceOf(Error::class, $error);
        $array = $error->toArray();
        $this->assertArrayHasKey('code', $array);
        $this->assertArrayHasKey('message', $array);
        $this->assertSame(404, $array['code']);
        $this->assertSame('Pet not found', $array['message']);
    }

    /**
     * Test that all models have fromArray method that returns instance.
     */
    public function testAllModelsFromArrayReturnsInstance(): void
    {
        $testData = $this->getTestDataForModels();

        foreach ($this->expectedModels as $name => $class) {
            $data = $testData[$name] ?? [];
            $instance = $class::fromArray($data);
            $this->assertInstanceOf(
                $class,
                $instance,
                "{$name}::fromArray() should return instance of {$name}"
            );
        }
    }

    /**
     * Test that all models have toArray method that returns array.
     */
    public function testAllModelsToArrayReturnsArray(): void
    {
        $testData = $this->getTestDataForModels();

        foreach ($this->expectedModels as $name => $class) {
            $data = $testData[$name] ?? [];
            $instance = $class::fromArray($data);
            $array = $instance->toArray();
            $this->assertIsArray(
                $array,
                "{$name}::toArray() should return array"
            );
        }
    }

    /**
     * Test that fromArray is callable as static method.
     */
    public function testFromArrayIsStaticAndPublic(): void
    {
        // If fromArray was not static/public, these calls would fail
        $pet = Pet::fromArray(['id' => 1, 'name' => 'Test', 'tag' => 'test']);
        $this->assertInstanceOf(Pet::class, $pet);

        $newPet = NewPet::fromArray(['name' => 'Test']);
        $this->assertInstanceOf(NewPet::class, $newPet);

        $error = Error::fromArray(['code' => 400, 'message' => 'Error']);
        $this->assertInstanceOf(Error::class, $error);
    }

    /**
     * Test that toArray is callable as instance method.
     */
    public function testToArrayIsInstanceMethodAndPublic(): void
    {
        // If toArray was static or not public, these calls would fail
        $pet = Pet::fromArray(['id' => 1, 'name' => 'Test', 'tag' => 'test']);
        $result = $pet->toArray();
        $this->assertIsArray($result);

        $newPet = NewPet::fromArray(['name' => 'Test']);
        $result = $newPet->toArray();
        $this->assertIsArray($result);

        $error = Error::fromArray(['code' => 400, 'message' => 'Error']);
        $result = $error->toArray();
        $this->assertIsArray($result);
    }

    /**
     * Test that fromArray -> toArray roundtrip preserves data.
     */
    public function testFromArrayToArrayRoundtrip(): void
    {
        $originalData = [
            'id' => 123,
            'name' => 'Max',
            'tag' => 'dog',
        ];

        $pet = Pet::fromArray($originalData);
        $resultData = $pet->toArray();

        $this->assertSame($originalData['id'], $resultData['id']);
        $this->assertSame($originalData['name'], $resultData['name']);
        $this->assertSame($originalData['tag'], $resultData['tag']);
    }

    /**
     * Test that NewPet tag property accepts null (optional).
     */
    public function testNewPetTagAcceptsNull(): void
    {
        $newPet = NewPet::fromArray([
            'name' => 'Whiskers',
            'tag' => null,
        ]);

        $this->assertInstanceOf(NewPet::class, $newPet);
        $array = $newPet->toArray();
        $this->assertArrayHasKey('tag', $array);
    }

    /**
     * Test that models can be created with required parameters only.
     */
    public function testModelsCanBeCreatedWithRequiredOnly(): void
    {
        // Pet requires id and name, tag is optional
        $pet = Pet::fromArray(['id' => 1, 'name' => 'Test']);
        $this->assertInstanceOf(Pet::class, $pet);

        // NewPet requires name, tag is optional
        $newPet = NewPet::fromArray(['name' => 'Test']);
        $this->assertInstanceOf(NewPet::class, $newPet);

        // Error requires code and message
        $error = Error::fromArray(['code' => 400, 'message' => 'Test']);
        $this->assertInstanceOf(Error::class, $error);
    }

    /**
     * Test that Error model required properties work correctly.
     */
    public function testErrorRequiredPropertiesWork(): void
    {
        $error = Error::fromArray([
            'code' => 500,
            'message' => 'Internal server error',
        ]);

        $array = $error->toArray();
        $this->assertSame(500, $array['code']);
        $this->assertSame('Internal server error', $array['message']);
    }

    /**
     * Provide test data for each model class.
     *
     * @return array<string, array<string, mixed>>
     */
    private function getTestDataForModels(): array
    {
        return [
            'Pet' => [
                'id' => 1,
                'name' => 'TestPet',
                'tag' => 'test',
            ],
            'NewPet' => [
                'name' => 'NewTestPet',
                'tag' => 'test',
            ],
            'Error' => [
                'code' => 400,
                'message' => 'Test error',
            ],
        ];
    }
}
