<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Controller\GetGameController;
use TictactoeApi\Api\GameplayApiServiceInterface;

/**
 * Tests for generated GetGameController (Symfony) - controller without body param
 *
 * php-max generator creates per-operation controllers that inject
 * per-TAG service interfaces (not per-operation interfaces).
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

    public function test_controller_extends_abstract_controller(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $parent = $reflection->getParentClass();

        $this->assertNotFalse($parent, 'Controller should have a parent class');
        $this->assertEquals(
            'Symfony\Bundle\FrameworkBundle\Controller\AbstractController',
            $parent->getName()
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

    public function test_controller_accepts_request_and_path_params(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        // Should have Request + path params
        $this->assertGreaterThanOrEqual(2, count($params), 'Should have Request and path params');

        // First param should be Request
        $requestParam = $params[0];
        $type = $requestParam->getType();
        $this->assertNotNull($type, 'Request parameter should be typed');
        $this->assertEquals('Symfony\Component\HttpFoundation\Request', $type->getName());

        // Second param should be the path parameter (gameId or game_id)
        $gameIdParam = $params[1];
        $this->assertMatchesRegularExpression(
            '/^(game_id|gameId)$/',
            $gameIdParam->getName(),
            'Path parameter should be game_id or gameId'
        );
        $type = $gameIdParam->getType();
        $this->assertNotNull($type, 'Path parameter should be typed');
        $this->assertEquals('string', $type->getName());
    }

    public function test_controller_has_service_dependency(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertGreaterThanOrEqual(1, count($params));

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Service parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        // php-max uses per-TAG service interfaces
        // getGame has multiple tags; controller uses the last-processed tag (Gameplay)
        $this->assertEquals(
            'TictactoeApi\Api\GameplayApiServiceInterface',
            $type->getName()
        );
    }

    public function test_controller_has_no_validator_dependency(): void
    {
        $reflection = new \ReflectionClass(GetGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();

        // Should only have service, no validator (no body param)
        $this->assertCount(1, $params, 'Should only have service dependency (no body param = no validator)');
    }

    public function test_return_type_is_json_response(): void
    {
        $reflection = new \ReflectionMethod(GetGameController::class, '__invoke');
        $returnType = $reflection->getReturnType();

        $this->assertNotNull($returnType);
        $this->assertInstanceOf(\ReflectionNamedType::class, $returnType);
        $this->assertEquals('Symfony\Component\HttpFoundation\JsonResponse', $returnType->getName());
    }
}
