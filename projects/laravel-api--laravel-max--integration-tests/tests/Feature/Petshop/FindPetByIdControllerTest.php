<?php

namespace Tests\Feature\Petshop;

use PHPUnit\Framework\TestCase;
use PetshopApi\Api\Http\Controllers\FindPetByIdController;
use PetshopApi\Api\Handlers\RetrievalApiHandlerInterface;

/**
 * Tests for generated FindPetByIdController
 */
class FindPetByIdControllerTest extends TestCase
{
    public function test_controller_class_exists(): void
    {
        $this->assertTrue(
            class_exists(FindPetByIdController::class),
            'FindPetByIdController class should exist'
        );
    }

    public function test_controller_is_invokable(): void
    {
        $reflection = new \ReflectionClass(FindPetByIdController::class);
        $this->assertTrue(
            $reflection->hasMethod('__invoke'),
            'Controller should be invokable'
        );
    }

    public function test_controller_accepts_request_and_path_param(): void
    {
        $reflection = new \ReflectionClass(FindPetByIdController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        $this->assertCount(2, $params, 'Should have Request and path param');

        // First param should be Request
        $requestParam = $params[0];
        $type = $requestParam->getType();
        $this->assertNotNull($type);
        $this->assertEquals('Illuminate\Http\Request', $type->getName());

        // Second param should be id (int)
        $idParam = $params[1];
        $this->assertEquals('id', $idParam->getName());
        $type = $idParam->getType();
        $this->assertNotNull($type);
        $this->assertEquals('int', $type->getName());
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(FindPetByIdController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertCount(1, $params);

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Handler parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals(RetrievalApiHandlerInterface::class, $type->getName());
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(FindPetByIdController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('Illuminate\Http\JsonResponse', $returnType->getName());
    }
}
