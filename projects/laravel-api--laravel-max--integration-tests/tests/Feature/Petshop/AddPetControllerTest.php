<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Api\Http\Controllers\AddPetController;
use PetshopApi\Api\Http\Requests\AddPetFormRequest;
use PetshopApi\Api\Handlers\WorkflowApiHandlerInterface;

/**
 * Tests for generated AddPetController
 */
class AddPetControllerTest extends TestCase
{
    public function test_controller_class_exists(): void
    {
        $this->assertTrue(
            class_exists(AddPetController::class),
            'AddPetController class should exist'
        );
    }

    public function test_controller_is_invokable(): void
    {
        $reflection = new \ReflectionClass(AddPetController::class);
        $this->assertTrue(
            $reflection->hasMethod('__invoke'),
            'Controller should be invokable'
        );
    }

    public function test_controller_accepts_form_request(): void
    {
        $reflection = new \ReflectionClass(AddPetController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        $this->assertCount(1, $params, 'Should have exactly one parameter');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals(AddPetFormRequest::class, $type->getName());
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(AddPetController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertCount(1, $params);

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Handler parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals(WorkflowApiHandlerInterface::class, $type->getName());
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(AddPetController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('Illuminate\Http\JsonResponse', $returnType->getName());
    }
}
