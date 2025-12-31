<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Api\Http\Controllers\AddPetController;
use TictactoeApi\Api\Http\Requests\AddPetFormRequest;
use TictactoeApi\Api\Handlers\WorkflowApiHandler;

/**
 * Tests for generated AddPetController
 *
 * Validates that the generator produces Laravel-compliant code structure
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
        $reflection = new ReflectionClass(AddPetController::class);
        $this->assertTrue(
            $reflection->hasMethod('__invoke'),
            'Controller should be invokable (have __invoke method)'
        );
    }

    public function test_controller_accepts_form_request(): void
    {
        $reflection = new ReflectionClass(AddPetController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        $this->assertCount(1, $params, 'Should have exactly one parameter');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Parameter should be typed');
        $this->assertEquals('TictactoeApi\Api\Http\Requests\AddPetFormRequest', $type->getName(),
            'Parameter should be typed as AddPetFormRequest');
    }

    public function test_controller_has_handler_dependency(): void
    {
        $reflection = new ReflectionClass(AddPetController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertCount(1, $params, 'Constructor should have exactly one parameter');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Handler parameter should be typed');
        $this->assertEquals('TictactoeApi\Api\Handlers\WorkflowApiHandler', $type->getName(),
            'Handler should be typed as WorkflowApiHandler interface');
    }
}
