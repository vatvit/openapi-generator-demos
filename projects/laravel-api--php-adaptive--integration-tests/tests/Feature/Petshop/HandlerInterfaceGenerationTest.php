<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Http\JsonResponse;
use PetshopApi\Api\PetsHandlerInterface;
use PetshopApi\Api\ManagementHandlerInterface;
use PetshopApi\Api\CreationHandlerInterface;
use PetshopApi\Api\RetrievalHandlerInterface;
use PetshopApi\Api\DetailsHandlerInterface;
use PetshopApi\Api\PublicHandlerInterface;

/**
 * Tests that verify the generated handler interfaces have correct structure.
 */
class HandlerInterfaceGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Handler interfaces to test
     */
    private array $expectedInterfaces = [
        'Pets' => PetsHandlerInterface::class,
        'Management' => ManagementHandlerInterface::class,
        'Creation' => CreationHandlerInterface::class,
        'Retrieval' => RetrievalHandlerInterface::class,
        'Details' => DetailsHandlerInterface::class,
        'Public' => PublicHandlerInterface::class,
    ];

    /**
     * Test that all expected handler interfaces exist.
     */
    public function testAllHandlerInterfacesExist(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $this->assertTrue(
                interface_exists($interface),
                "Handler interface {$name} should exist"
            );
        }
    }

    /**
     * Test that all handler interfaces are actual interfaces (not classes).
     */
    public function testAllAreInterfaces(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $reflection = new ReflectionClass($interface);
            $this->assertTrue(
                $reflection->isInterface(),
                "{$name} should be an interface"
            );
        }
    }

    /**
     * Test PetsHandlerInterface has expected methods.
     */
    public function testPetsHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['addPet', 'deletePet', 'findPetById', 'findPets'];
        $reflection = new ReflectionClass(PetsHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "PetsHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test ManagementHandlerInterface has expected methods.
     */
    public function testManagementHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['addPet', 'deletePet'];
        $reflection = new ReflectionClass(ManagementHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "ManagementHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test CreationHandlerInterface has expected methods.
     */
    public function testCreationHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['addPet'];
        $reflection = new ReflectionClass(CreationHandlerInterface::class);

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                $reflection->hasMethod($method),
                "CreationHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test that all handler methods return JsonResponse.
     */
    public function testAllMethodsReturnJsonResponse(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $reflection = new ReflectionClass($interface);
            foreach ($reflection->getMethods() as $method) {
                $returnType = $method->getReturnType();
                $this->assertNotNull(
                    $returnType,
                    "Method {$name}::{$method->getName()} should have a return type"
                );
                $this->assertSame(
                    JsonResponse::class,
                    $returnType->getName(),
                    "Method {$name}::{$method->getName()} should return JsonResponse"
                );
            }
        }
    }

    /**
     * Test addPet method has correct parameters.
     */
    public function testAddPetMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            PetsHandlerInterface::class,
            'addPet'
        );
        $params = $reflection->getParameters();

        $this->assertCount(1, $params, "addPet should have 1 parameter");
        $this->assertSame('new_pet', $params[0]->getName());
        $this->assertSame(
            'PetshopApi\Model\NewPet',
            $params[0]->getType()->getName()
        );
    }

    /**
     * Test deletePet method has correct parameters.
     */
    public function testDeletePetMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            PetsHandlerInterface::class,
            'deletePet'
        );
        $params = $reflection->getParameters();

        $this->assertCount(1, $params, "deletePet should have 1 parameter");
        $this->assertSame('id', $params[0]->getName());
        $this->assertSame('int', $params[0]->getType()->getName());
        $this->assertFalse($params[0]->isOptional(), "id should be required");
    }

    /**
     * Test findPetById method has correct parameters.
     */
    public function testFindPetByIdMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            PetsHandlerInterface::class,
            'findPetById'
        );
        $params = $reflection->getParameters();

        $this->assertCount(1, $params, "findPetById should have 1 parameter");
        $this->assertSame('id', $params[0]->getName());
        $this->assertSame('int', $params[0]->getType()->getName());
    }

    /**
     * Test findPets method has correct parameters.
     */
    public function testFindPetsMethodParameters(): void
    {
        $reflection = new ReflectionMethod(
            PetsHandlerInterface::class,
            'findPets'
        );
        $params = $reflection->getParameters();

        $this->assertCount(2, $params, "findPets should have 2 parameters");
        $this->assertSame('tags', $params[0]->getName());
        $this->assertSame('limit', $params[1]->getName());

        // Both should be optional
        $this->assertTrue($params[0]->isOptional(), "tags should be optional");
        $this->assertTrue($params[1]->isOptional(), "limit should be optional");
    }

    /**
     * Test that all methods are public.
     */
    public function testAllMethodsArePublic(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $reflection = new ReflectionClass($interface);
            foreach ($reflection->getMethods() as $method) {
                $this->assertTrue(
                    $method->isPublic(),
                    "Method {$name}::{$method->getName()} should be public"
                );
            }
        }
    }
}
