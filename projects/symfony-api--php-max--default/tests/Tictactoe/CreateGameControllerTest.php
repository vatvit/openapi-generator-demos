<?php

declare(strict_types=1);

namespace App\Tests\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Api\Controller\CreateGameController;
use TictactoeApi\Api\Dto\CreateGameRequest;
use TictactoeApi\Api\Handler\GameManagementApiHandlerInterface;

/**
 * Tests for generated CreateGameController
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

        $this->assertCount(1, $params, 'Should have exactly one parameter');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals('TictactoeApi\Api\Dto\CreateGameRequest', $type->getName());
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertGreaterThanOrEqual(1, count($params));

        $handlerParam = $params[0];
        $type = $handlerParam->getType();

        $this->assertNotNull($type, 'Handler parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals('TictactoeApi\Api\Handler\GameManagementApiHandlerInterface', $type->getName());
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(CreateGameController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('Symfony\Component\HttpFoundation\JsonResponse', $returnType->getName());
    }
}
