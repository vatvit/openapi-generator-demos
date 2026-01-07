<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use PetshopApi\Model\Pet;
use PetshopApi\Model\NewPet;
use PetshopApi\Model\Error;

/**
 * Tests that verify the generated Petshop model classes have correct structure.
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
     * Test that Pet model has expected properties.
     */
    public function testPetModelHasExpectedProperties(): void
    {
        $reflection = new ReflectionClass(Pet::class);

        // Pet should have id (from allOf with NewPet + id)
        $this->assertTrue(
            $reflection->hasProperty('id'),
            "Pet should have 'id' property"
        );
        $this->assertTrue(
            $reflection->hasProperty('name'),
            "Pet should have 'name' property"
        );
    }

    /**
     * Test that NewPet model has expected properties.
     */
    public function testNewPetModelHasExpectedProperties(): void
    {
        $reflection = new ReflectionClass(NewPet::class);

        $this->assertTrue(
            $reflection->hasProperty('name'),
            "NewPet should have 'name' property"
        );
        $this->assertTrue(
            $reflection->hasProperty('tag'),
            "NewPet should have 'tag' property"
        );
    }

    /**
     * Test that Error model has expected properties.
     */
    public function testErrorModelHasExpectedProperties(): void
    {
        $reflection = new ReflectionClass(Error::class);

        $this->assertTrue(
            $reflection->hasProperty('code'),
            "Error should have 'code' property"
        );
        $this->assertTrue(
            $reflection->hasProperty('message'),
            "Error should have 'message' property"
        );
    }

    /**
     * Test that all models have fromArray static method.
     */
    public function testAllModelsHaveFromArrayMethod(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'fromArray'),
                "Model {$name} should have fromArray method"
            );

            $reflection = new ReflectionMethod($class, 'fromArray');
            $this->assertTrue($reflection->isStatic(), "fromArray should be static in {$name}");
            $this->assertTrue($reflection->isPublic(), "fromArray should be public in {$name}");
        }
    }

    /**
     * Test that all models have toArray method.
     */
    public function testAllModelsHaveToArrayMethod(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'toArray'),
                "Model {$name} should have toArray method"
            );

            $reflection = new ReflectionMethod($class, 'toArray');
            $this->assertFalse($reflection->isStatic(), "toArray should not be static in {$name}");
            $this->assertTrue($reflection->isPublic(), "toArray should be public in {$name}");
        }
    }

    /**
     * Test that fromArray returns self type.
     */
    public function testFromArrayReturnType(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $reflection = new ReflectionMethod($class, 'fromArray');
            $returnType = $reflection->getReturnType();

            $this->assertNotNull($returnType, "fromArray should have return type in {$name}");
            $this->assertSame('self', $returnType->getName(), "fromArray should return self in {$name}");
        }
    }

    /**
     * Test that toArray returns array type.
     */
    public function testToArrayReturnType(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $reflection = new ReflectionMethod($class, 'toArray');
            $returnType = $reflection->getReturnType();

            $this->assertNotNull($returnType, "toArray should have return type in {$name}");
            $this->assertSame('array', $returnType->getName(), "toArray should return array in {$name}");
        }
    }

    /**
     * Test that NewPet tag property is optional (nullable).
     */
    public function testNewPetTagIsOptional(): void
    {
        $reflection = new ReflectionClass(NewPet::class);
        $property = $reflection->getProperty('tag');
        $type = $property->getType();

        $this->assertNotNull($type, "tag should have a type");
        $this->assertTrue($type->allowsNull(), "tag should be nullable");
    }

    /**
     * Test constructor parameter order (required before optional).
     */
    public function testConstructorParameterOrder(): void
    {
        foreach ($this->expectedModels as $name => $class) {
            $reflection = new ReflectionClass($class);
            $constructor = $reflection->getConstructor();

            if ($constructor === null) {
                continue;
            }

            $params = $constructor->getParameters();
            $seenOptional = false;

            foreach ($params as $param) {
                if ($param->isOptional()) {
                    $seenOptional = true;
                } else {
                    $this->assertFalse(
                        $seenOptional,
                        "In {$name}: Required parameter '{$param->getName()}' should not come after optional parameters"
                    );
                }
            }
        }
    }

    /**
     * Test that Error model has required properties typed as non-nullable.
     */
    public function testErrorRequiredPropertiesAreNotNullable(): void
    {
        $reflection = new ReflectionClass(Error::class);

        $codeProperty = $reflection->getProperty('code');
        $codeType = $codeProperty->getType();
        $this->assertNotNull($codeType);
        $this->assertFalse($codeType->allowsNull(), "code should not be nullable");

        $messageProperty = $reflection->getProperty('message');
        $messageType = $messageProperty->getType();
        $this->assertNotNull($messageType);
        $this->assertFalse($messageType->allowsNull(), "message should not be nullable");
    }
}
