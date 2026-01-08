<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;
use PetshopApi\Http\Responses\AddPetResponse;
use PetshopApi\Http\Responses\DeletePetResponse;
use PetshopApi\Http\Responses\FindPetByIdResponse;
use PetshopApi\Http\Responses\FindPetsResponse;

/**
 * Tests that verify the generated response classes behave correctly.
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
     * Test that all response classes can be instantiated via factory methods.
     */
    public function testAllResponsesCanBeInstantiated(): void
    {
        // Test that each response class can create instances via static factories
        $this->assertInstanceOf(AddPetResponse::class, AddPetResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(DeletePetResponse::class, DeletePetResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(FindPetByIdResponse::class, FindPetByIdResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(FindPetsResponse::class, FindPetsResponse::ok(['test' => 'data']));
    }

    /**
     * Test that all response classes have toJsonResponse method defined.
     */
    public function testAllResponsesHaveToJsonResponseMethod(): void
    {
        // toJsonResponse() requires Laravel container, so we only verify method exists
        foreach ($this->expectedResponses as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'toJsonResponse'),
                "{$name}Response should have toJsonResponse method"
            );
        }
    }

    /**
     * Test that all response classes have ok static factory method.
     */
    public function testAllResponsesHaveOkMethod(): void
    {
        // If ok() was not static/public, these calls would fail
        $this->assertInstanceOf(AddPetResponse::class, AddPetResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(DeletePetResponse::class, DeletePetResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(FindPetByIdResponse::class, FindPetByIdResponse::ok(['test' => 'data']));
        $this->assertInstanceOf(FindPetsResponse::class, FindPetsResponse::ok(['test' => 'data']));
    }

    /**
     * Test that all response classes have created static factory method.
     */
    public function testAllResponsesHaveCreatedMethod(): void
    {
        // If created() was not static/public, these calls would fail
        $this->assertInstanceOf(AddPetResponse::class, AddPetResponse::created(['test' => 'data']));
        $this->assertInstanceOf(DeletePetResponse::class, DeletePetResponse::created(['test' => 'data']));
        $this->assertInstanceOf(FindPetByIdResponse::class, FindPetByIdResponse::created(['test' => 'data']));
        $this->assertInstanceOf(FindPetsResponse::class, FindPetsResponse::created(['test' => 'data']));
    }

    /**
     * Test that all response classes have noContent static factory method.
     */
    public function testAllResponsesHaveNoContentMethod(): void
    {
        // If noContent() was not static/public, these calls would fail
        $this->assertInstanceOf(AddPetResponse::class, AddPetResponse::noContent());
        $this->assertInstanceOf(DeletePetResponse::class, DeletePetResponse::noContent());
        $this->assertInstanceOf(FindPetByIdResponse::class, FindPetByIdResponse::noContent());
        $this->assertInstanceOf(FindPetsResponse::class, FindPetsResponse::noContent());
    }

    /**
     * Test that all response classes have error static factory method.
     */
    public function testAllResponsesHaveErrorMethod(): void
    {
        // If error() was not static/public, these calls would fail
        $this->assertInstanceOf(AddPetResponse::class, AddPetResponse::error('Error', 400));
        $this->assertInstanceOf(DeletePetResponse::class, DeletePetResponse::error('Error', 400));
        $this->assertInstanceOf(FindPetByIdResponse::class, FindPetByIdResponse::error('Error', 400));
        $this->assertInstanceOf(FindPetsResponse::class, FindPetsResponse::error('Error', 400));
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
     * Test that all response classes have getStatusCode method returning int.
     */
    public function testAllResponsesHaveGetStatusCodeMethod(): void
    {
        foreach ($this->expectedResponses as $name => $class) {
            $response = $class::ok(['test' => 'data']);
            $statusCode = $response->getStatusCode();
            $this->assertIsInt(
                $statusCode,
                "{$name}Response::getStatusCode() should return int"
            );
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
