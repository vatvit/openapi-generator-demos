<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Http\JsonResponse;
use PetshopApi\Http\Responses\AddPetResponse;
use PetshopApi\Http\Responses\DeletePetResponse;
use PetshopApi\Http\Responses\FindPetByIdResponse;
use PetshopApi\Http\Responses\FindPetsResponse;

/**
 * Tests that verify the generated response classes have correct structure.
 */
class ResponseGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Response classes to test
     */
    private array $expectedResponses = [
        'AddPet' => AddPetResponse::class,
        'DeletePet' => DeletePetResponse::class,
        'FindPetById' => FindPetByIdResponse::class,
        'FindPets' => FindPetsResponse::class,
    ];

    /**
     * Test that all expected response classes exist.
     */
    public function testAllResponseClassesExist(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Response class {$name} should exist"
            );
        }
    }

    /**
     * Test that all response classes are final.
     */
    public function testAllResponsesAreFinal(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isFinal(),
                "{$name}Response should be final"
            );
        }
    }

    /**
     * Test that all response classes have toJsonResponse method.
     */
    public function testAllResponsesHaveToJsonResponseMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'toJsonResponse'),
                "{$name}Response should have toJsonResponse method"
            );

            $reflection = new ReflectionMethod($class, 'toJsonResponse');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame(JsonResponse::class, $returnType->getName());
        }
    }

    /**
     * Test that all response classes have ok static factory method.
     */
    public function testAllResponsesHaveOkMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'ok'),
                "{$name}Response should have ok method"
            );

            $reflection = new ReflectionMethod($class, 'ok');
            $this->assertTrue($reflection->isStatic());
            $this->assertTrue($reflection->isPublic());
        }
    }

    /**
     * Test that all response classes have created static factory method.
     */
    public function testAllResponsesHaveCreatedMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'created'),
                "{$name}Response should have created method"
            );

            $reflection = new ReflectionMethod($class, 'created');
            $this->assertTrue($reflection->isStatic());
            $this->assertTrue($reflection->isPublic());
        }
    }

    /**
     * Test that all response classes have noContent static factory method.
     */
    public function testAllResponsesHaveNoContentMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'noContent'),
                "{$name}Response should have noContent method"
            );

            $reflection = new ReflectionMethod($class, 'noContent');
            $this->assertTrue($reflection->isStatic());
            $this->assertTrue($reflection->isPublic());
        }
    }

    /**
     * Test that all response classes have error static factory method.
     */
    public function testAllResponsesHaveErrorMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'error'),
                "{$name}Response should have error method"
            );

            $reflection = new ReflectionMethod($class, 'error');
            $this->assertTrue($reflection->isStatic());
            $this->assertTrue($reflection->isPublic());
        }
    }

    /**
     * Test that all response classes have getData method.
     */
    public function testAllResponsesHaveGetDataMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'getData'),
                "{$name}Response should have getData method"
            );
        }
    }

    /**
     * Test that all response classes have getStatusCode method.
     */
    public function testAllResponsesHaveGetStatusCodeMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'getStatusCode'),
                "{$name}Response should have getStatusCode method"
            );

            $reflection = new ReflectionMethod($class, 'getStatusCode');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame('int', $returnType->getName());
        }
    }

    /**
     * Test ok factory method returns correct status code.
     */
    public function testOkReturnsCorrectStatusCode(): void
    {
        $response = AddPetResponse::ok(['test' => 'data']);
        $this->assertSame(200, $response->getStatusCode());
    }

    /**
     * Test created factory method returns correct status code.
     */
    public function testCreatedReturnsCorrectStatusCode(): void
    {
        $response = AddPetResponse::created(['test' => 'data']);
        $this->assertSame(201, $response->getStatusCode());
    }

    /**
     * Test noContent factory method returns correct status code.
     */
    public function testNoContentReturnsCorrectStatusCode(): void
    {
        $response = AddPetResponse::noContent();
        $this->assertSame(204, $response->getStatusCode());
        $this->assertNull($response->getData());
    }

    /**
     * Test error factory method returns correct structure.
     */
    public function testErrorReturnsCorrectStructure(): void
    {
        $response = AddPetResponse::error('Something went wrong', 400);
        $this->assertSame(400, $response->getStatusCode());

        $data = $response->getData();
        $this->assertIsArray($data);
        $this->assertArrayHasKey('message', $data);
        $this->assertSame('Something went wrong', $data['message']);
    }
}
