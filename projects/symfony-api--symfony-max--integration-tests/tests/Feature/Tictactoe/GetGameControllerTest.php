<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Api\Controller\GetGameController;
use TictactoeApi\Api\Handler\GetGameApiHandlerInterface;

/**
 * Tests for generated GetGameController (Symfony) - controller without body param
 *
 * php-max generator creates per-operation controllers that inject
 * per-operation handler interfaces.
 */
class GetGameControllerTest extends TestCase
{
    public function test_controller_class_exists(): void
    {
        $this->assertTrue(
            class_exists(GetGameController::class),
            'GetGameController class should exist'
        );
    }

    public function test_controller_is_final(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $this->assertTrue(
            $reflection->isFinal(),
            'Controller should be final'
        );
    }

    public function test_controller_is_invokable(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $this->assertTrue(
            $reflection->hasMethod('__invoke'),
            'Controller should be invokable'
        );
    }

    public function test_controller_accepts_path_param(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        // Should have path param (game_id)
        $this->assertCount(1, $params, 'Should have one path parameter');

        // Parameter should be the path parameter (game_id)
        $gameIdParam = $params[0];
        $this->assertEquals(
            'game_id',
            $gameIdParam->getName(),
            'Path parameter should be game_id'
        );
        $type = $gameIdParam->getType();
        $this->assertNotNull($type, 'Path parameter should be typed');
        $this->assertEquals('string', $type->getName());
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertGreaterThanOrEqual(1, count($params));

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Handler parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals(
            GetGameApiHandlerInterface::class,
            $type->getName()
        );
    }

    public function test_controller_has_serializer_dependency(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();

        // Should have handler and serializer
        $this->assertCount(2, $params, 'Should have handler and serializer dependencies');
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(GetGameController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('Symfony\Component\HttpFoundation\JsonResponse', $returnType->getName());
    }

    public function test_controller_has_route_attribute(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $attributes = $reflection->getAttributes('Symfony\Component\Routing\Attribute\Route');

        $this->assertNotEmpty($attributes, 'Controller should have Route attribute');
    }
}
