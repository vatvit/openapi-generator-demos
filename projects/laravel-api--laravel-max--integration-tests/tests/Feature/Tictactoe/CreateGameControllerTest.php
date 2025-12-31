<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Api\Http\Controllers\CreateGameController;
use TictactoeApi\Api\Http\Requests\CreateGameFormRequest;
use TictactoeApi\Api\Handlers\GameManagementApiHandler;

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

    public function test_controller_accepts_form_request(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        $this->assertCount(1, $params, 'Should have exactly one parameter');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Parameter should be typed');
        $this->assertEquals('TictactoeApi\Api\Http\Requests\CreateGameFormRequest', $type->getName());
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertCount(1, $params);

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Handler parameter should be typed');
        $this->assertEquals('TictactoeApi\Api\Handlers\GameManagementApiHandler', $type->getName());
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(CreateGameController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertEquals('Illuminate\Http\JsonResponse', $returnType->getName());
    }
}
