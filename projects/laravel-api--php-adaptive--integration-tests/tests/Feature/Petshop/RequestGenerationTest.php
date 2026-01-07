<?php

declare(strict_types=1);

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionMethod;
use Illuminate\Foundation\Http\FormRequest;
use PetshopApi\Http\Requests\AddPetRequest;
use PetshopApi\Http\Requests\DeletePetRequest;
use PetshopApi\Http\Requests\FindPetByIdRequest;
use PetshopApi\Http\Requests\FindPetsRequest;

/**
 * Tests that verify the generated request classes have correct structure.
 */
class RequestGenerationTest extends TestCase
{
    /**
     * @var array<string, class-string> Request classes to test
     */
    private array $expectedRequests = [
        'AddPet' => AddPetRequest::class,
        'DeletePet' => DeletePetRequest::class,
        'FindPetById' => FindPetByIdRequest::class,
        'FindPets' => FindPetsRequest::class,
    ];

    /**
     * Test that all expected request classes exist.
     */
    public function testAllRequestClassesExist(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $this->assertTrue(
                class_exists($class),
                "Request class {$name} should exist"
            );
        }
    }

    /**
     * Test that all request classes extend FormRequest.
     */
    public function testAllRequestsExtendFormRequest(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isSubclassOf(FormRequest::class),
                "{$name}Request should extend FormRequest"
            );
        }
    }

    /**
     * Test that all request classes are final.
     */
    public function testAllRequestsAreFinal(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $reflection = new ReflectionClass($class);
            $this->assertTrue(
                $reflection->isFinal(),
                "{$name}Request should be final"
            );
        }
    }

    /**
     * Test that all request classes have authorize method.
     */
    public function testAllRequestsHaveAuthorizeMethod(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'authorize'),
                "{$name}Request should have authorize method"
            );

            $reflection = new ReflectionMethod($class, 'authorize');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame('bool', $returnType->getName());
        }
    }

    /**
     * Test that all request classes have rules method.
     */
    public function testAllRequestsHaveRulesMethod(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $this->assertTrue(
                method_exists($class, 'rules'),
                "{$name}Request should have rules method"
            );

            $reflection = new ReflectionMethod($class, 'rules');
            $returnType = $reflection->getReturnType();
            $this->assertNotNull($returnType);
            $this->assertSame('array', $returnType->getName());
        }
    }

    /**
     * Test AddPetRequest has correct validation rules.
     */
    public function testAddPetRequestRules(): void
    {
        $request = new AddPetRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('name', $rules);
        $this->assertContains('required', $rules['name']);
        $this->assertContains('string', $rules['name']);

        $this->assertArrayHasKey('tag', $rules);
        $this->assertContains('nullable', $rules['tag']);
    }

    /**
     * Test FindPetsRequest has correct validation rules.
     */
    public function testFindPetsRequestRules(): void
    {
        $request = new FindPetsRequest();
        $rules = $request->rules();

        $this->assertArrayHasKey('tags', $rules);
        $this->assertArrayHasKey('limit', $rules);
        $this->assertContains('nullable', $rules['limit']);
        $this->assertContains('integer', $rules['limit']);
    }

    /**
     * Test that authorize returns true by default.
     */
    public function testAuthorizeReturnsTrue(): void
    {
        foreach ($this->expectedRequests as $name => $class) {
            $request = new $class();
            $this->assertTrue(
                $request->authorize(),
                "{$name}Request::authorize() should return true"
            );
        }
    }
}
