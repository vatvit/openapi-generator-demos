<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Api\Controller\CreateGameController;
use TictactoeApi\Api\Handler\CreateGameApiHandlerInterface;
use TictactoeApi\Api\Dto\CreateGameRequest;

/**
 * Tests for generated CreateGameController (Symfony)
 *
 * php-max generator creates per-operation controllers that inject
 * per-operation handler interfaces.
 */
class CreateGameControllerTest extends TestCase
{
    public function test_controller_class_exists(): void
    {
        $this->assertTrue(
            class_exists(CreateGameController::class),
            'CreateGameController class should exist'
        );
    }

    public function test_controller_is_final(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $this->assertTrue(
            $reflection->isFinal(),
            'Controller should be final'
        );
    }

    public function test_controller_is_invokable(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $this->assertTrue(
            $reflection->hasMethod('__invoke'),
            'Controller should be invokable'
        );
    }

    public function test_controller_accepts_request_dto(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        $this->assertCount(1, $params, 'Should have one parameter (request DTO)');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals(CreateGameRequest::class, $type->getName());
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertGreaterThanOrEqual(1, count($params));

        // Find the handler parameter
        $handlerParam = null;
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType &&
                str_contains($type->getName(), 'HandlerInterface')) {
                $handlerParam = $param;
                break;
            }
        }

        $this->assertNotNull($handlerParam, 'Should have a handler interface dependency');
        $this->assertEquals(
            CreateGameApiHandlerInterface::class,
            $handlerParam->getType()->getName()
        );
    }

    public function test_controller_has_serializer_dependency(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();

        // Find the serializer parameter
        $serializerParam = null;
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType &&
                str_contains($type->getName(), 'SerializerInterface')) {
                $serializerParam = $param;
                break;
            }
        }

        $this->assertNotNull($serializerParam, 'Should have a serializer dependency');
        $this->assertEquals(
            'Symfony\Component\Serializer\SerializerInterface',
            $serializerParam->getType()->getName()
        );
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(CreateGameController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('Symfony\Component\HttpFoundation\JsonResponse', $returnType->getName());
    }

    public function test_controller_has_route_attribute(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $attributes = $reflection->getAttributes('Symfony\Component\Routing\Attribute\Route');

        $this->assertNotEmpty($attributes, 'Controller should have Route attribute');
    }
}
