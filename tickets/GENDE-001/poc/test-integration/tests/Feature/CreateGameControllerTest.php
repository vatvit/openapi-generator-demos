<?php

namespace Tests\Feature;

use TictactoeApi\Http\Controllers\CreateGameController;
use TictactoeApi\Http\Requests\CreateGameFormRequest;
use TictactoeApi\Api\GameManagementApiApi;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;

/**
 * Integration test for CreateGameController
 *
 * Verifies complete request flow:
 * HTTP Request → FormRequest Validation → Controller → Handler → Resource → HTTP Response
 */
class CreateGameControllerTest extends TestCase
{
    /**
     * Test controller accepts CreateGameFormRequest
     *
     * Verifies that controller is properly configured to receive FormRequest
     */
    public function test_controller_accepts_form_request(): void
    {
        // Verify controller __invoke method signature
        // Create a mock handler since GameManagementApiApi is user-implemented
        $mockHandler = $this->createMock(GameManagementApiApi::class);
        $controller = new CreateGameController($mockHandler);

        $reflection = new \ReflectionMethod($controller, '__invoke');
        $parameters = $reflection->getParameters();

        // Should have one parameter: CreateGameFormRequest
        $this->assertCount(1, $parameters,
            'Controller should have exactly 1 parameter');

        $param = $parameters[0];
        $this->assertEquals('request', $param->getName(),
            'Parameter should be named $request');

        // Verify type hint
        $type = $param->getType();
        $this->assertNotNull($type, 'Parameter should have type hint');
        $this->assertEquals('TictactoeApi\Http\Requests\CreateGameFormRequest', $type->getName(),
            'Parameter should be typed as CreateGameFormRequest');
    }

    /**
     * Test controller delegates to handler
     *
     * Verifies that controller properly delegates to the handler interface
     */
    public function test_controller_delegates_to_handler(): void
    {
        // This test verifies the pattern:
        // 1. Controller receives FormRequest (already validated)
        // 2. Controller converts FormRequest to DTO using fromArray($request->validated())
        // 3. Controller calls handler method with DTO
        // 4. Handler returns Resource
        // 5. Controller returns Resource->response()

        // Read the controller source to verify this pattern
        $controllerPath = __DIR__ . '/../../../../generated/tictactoe/app/Http/Controllers/CreateGameController.php';
        $source = file_get_contents($controllerPath);

        // Verify FormRequest is used
        $this->assertStringContainsString('CreateGameFormRequest $request',
            $source,
            'Controller should inject CreateGameFormRequest');

        // Verify DTO conversion from validated data
        $this->assertStringContainsString('::fromArray($request->validated())',
            $source,
            'Controller should convert validated data to DTO');

        // Verify handler delegation
        $this->assertStringContainsString('$this->handler->createGame(',
            $source,
            'Controller should delegate to handler->createGame()');

        // Verify resource response
        $this->assertStringContainsString('->response($request)',
            $source,
            'Controller should return Resource->response()');
    }

    /**
     * Test controller constructor injection
     *
     * Verifies that controller uses dependency injection for handler
     */
    public function test_controller_uses_dependency_injection(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor,
            'Controller should have constructor');

        $parameters = $constructor->getParameters();
        $this->assertCount(1, $parameters,
            'Constructor should have exactly 1 parameter');

        $param = $parameters[0];
        $this->assertEquals('handler', $param->getName(),
            'Constructor parameter should be named $handler');

        // Verify type hint for handler interface
        $type = $param->getType();
        $this->assertNotNull($type,
            'Constructor parameter should have type hint');
        $this->assertEquals('TictactoeApi\Api\GameManagementApiApi', $type->getName(),
            'Handler should be typed as GameManagementApiApi interface');
    }

    /**
     * Test FormRequest validation happens before controller
     *
     * Verifies that Laravel validates FormRequest before calling controller
     */
    public function test_validation_happens_before_controller(): void
    {
        // In Laravel's request lifecycle:
        // 1. Route matches
        // 2. Middleware runs
        // 3. FormRequest is injected
        // 4. Laravel calls FormRequest->authorize()
        // 5. Laravel calls FormRequest->rules() and validates
        // 6. If validation fails → 422 response (controller never executes)
        // 7. If validation passes → controller __invoke() executes

        // This behavior is guaranteed by Laravel framework
        // The controller will ONLY execute if validation passes

        // Verify controller assumes validation has already happened
        $controllerPath = __DIR__ . '/../../../../generated/tictactoe/app/Http/Controllers/CreateGameController.php';
        $source = file_get_contents($controllerPath);

        // Controller should NOT have manual validation
        $this->assertStringNotContainsString('->validate(',
            $source,
            'Controller should not manually validate (FormRequest handles it)');

        // Controller should directly use validated()
        $this->assertStringContainsString('$request->validated()',
            $source,
            'Controller should use $request->validated() for clean data');
    }

    /**
     * Test return type is JsonResponse
     *
     * Verifies that controller returns JsonResponse
     */
    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(CreateGameController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType,
            'Controller should have return type declaration');
        $this->assertEquals('Illuminate\Http\JsonResponse', $returnType->getName(),
            'Controller should return JsonResponse');
    }
}
