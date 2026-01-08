<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Illuminate\Http\JsonResponse;
use PetshopApi\Api\PetsHandlerInterface;
use PetshopApi\Api\ManagementHandlerInterface;
use PetshopApi\Api\CreationHandlerInterface;
use PetshopApi\Api\RetrievalHandlerInterface;
use PetshopApi\Api\DetailsHandlerInterface;
use PetshopApi\Api\PublicHandlerInterface;
use PetshopApi\Model\NewPet;

/**
 * Tests that verify the generated handler interfaces behave correctly.
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
     * Test that mock implementations can be created for all interfaces.
     */
    public function testMockImplementationsCanBeCreated(): void
    {
        foreach ($this->expectedInterfaces as $name => $interface) {
            $mock = $this->createMock($interface);
            $this->assertInstanceOf(
                $interface,
                $mock,
                "Should be able to create mock for {$name}"
            );
        }
    }

    /**
     * Test PetsHandlerInterface has expected methods.
     */
    public function testPetsHandlerInterfaceMethods(): void
    {
        $expectedMethods = ['addPet', 'deletePet', 'findPetById', 'findPets'];

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(PetsHandlerInterface::class, $method),
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

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(ManagementHandlerInterface::class, $method),
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

        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists(CreationHandlerInterface::class, $method),
                "CreationHandlerInterface should have method '{$method}'"
            );
        }
    }

    /**
     * Test that PetsHandlerInterface methods return JsonResponse.
     */
    public function testPetsHandlerMethodsReturnJsonResponse(): void
    {
        $mock = $this->createMock(PetsHandlerInterface::class);

        $mock->method('addPet')->willReturn(new JsonResponse(['id' => 1], 201));
        $mock->method('deletePet')->willReturn(new JsonResponse(null, 204));
        $mock->method('findPetById')->willReturn(new JsonResponse(['id' => 1]));
        $mock->method('findPets')->willReturn(new JsonResponse([]));

        $newPet = NewPet::fromArray(['name' => 'Fluffy', 'tag' => 'cat']);
        $this->assertInstanceOf(JsonResponse::class, $mock->addPet($newPet));
        $this->assertInstanceOf(JsonResponse::class, $mock->deletePet(1));
        $this->assertInstanceOf(JsonResponse::class, $mock->findPetById(1));
        $this->assertInstanceOf(JsonResponse::class, $mock->findPets());
    }

    /**
     * Test addPet method accepts NewPet parameter.
     */
    public function testAddPetAcceptsNewPetParameter(): void
    {
        $mock = $this->createMock(PetsHandlerInterface::class);
        $mock->expects($this->once())
            ->method('addPet')
            ->with($this->isInstanceOf(NewPet::class))
            ->willReturn(new JsonResponse(['id' => 1], 201));

        $newPet = NewPet::fromArray(['name' => 'Buddy', 'tag' => 'dog']);
        $mock->addPet($newPet);
    }

    /**
     * Test deletePet method requires id parameter.
     */
    public function testDeletePetRequiresIdParameter(): void
    {
        $mock = $this->createMock(PetsHandlerInterface::class);
        $mock->expects($this->once())
            ->method('deletePet')
            ->with($this->equalTo(123))
            ->willReturn(new JsonResponse(null, 204));

        $mock->deletePet(123);
    }

    /**
     * Test findPetById method requires id parameter.
     */
    public function testFindPetByIdRequiresIdParameter(): void
    {
        $mock = $this->createMock(PetsHandlerInterface::class);
        $mock->expects($this->once())
            ->method('findPetById')
            ->with($this->equalTo(456))
            ->willReturn(new JsonResponse(['id' => 456]));

        $mock->findPetById(456);
    }

    /**
     * Test findPets method accepts optional parameters.
     */
    public function testFindPetsAcceptsOptionalParameters(): void
    {
        $mock = $this->createMock(PetsHandlerInterface::class);
        $mock->method('findPets')->willReturn(new JsonResponse([]));

        // Call with no parameters
        $result1 = $mock->findPets();
        $this->assertInstanceOf(JsonResponse::class, $result1);

        // Call with parameters
        $result2 = $mock->findPets(['cat', 'dog'], 10);
        $this->assertInstanceOf(JsonResponse::class, $result2);
    }

    /**
     * Test that all interface methods are public.
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
