<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Controller\CreateGameController;
use TictactoeApi\Api\GameManagementApiServiceInterface;
use TictactoeApi\Model\CreateGameRequest;

/**
 * Tests for generated CreateGameController (Symfony)
 *
 * php-max generator creates per-operation controllers that inject
 * per-TAG service interfaces (not per-operation interfaces).
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

    public function test_controller_extends_abstract_controller(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $parent = $reflection->getParentClass();

        $this->assertNotFalse($parent, 'Controller should have a parent class');
        $this->assertEquals(
            'Symfony\Bundle\FrameworkBundle\Controller\AbstractController',
            $parent->getName()
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

    public function test_controller_accepts_request_parameter(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $invokeMethod = $reflection->getMethod('__invoke');
        $params = $invokeMethod->getParameters();

        $this->assertGreaterThanOrEqual(1, count($params), 'Should have at least one parameter');

        $param = $params[0];
        $type = $param->getType();

        $this->assertNotNull($type, 'Parameter should be typed');
        $this->assertInstanceOf(\ReflectionNamedType::class, $type);
        $this->assertEquals('Symfony\Component\HttpFoundation\Request', $type->getName());
    }

    public function test_controller_has_service_dependency(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();
        $this->assertGreaterThanOrEqual(1, count($params));

        // Find the service/handler parameter
        $serviceParam = null;
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType &&
                str_contains($type->getName(), 'ServiceInterface')) {
                $serviceParam = $param;
                break;
            }
        }

        $this->assertNotNull($serviceParam, 'Should have a service interface dependency');
        // php-max uses per-TAG service interfaces (GameManagement contains createGame)
        $this->assertEquals(
            'TictactoeApi\Api\GameManagementApiServiceInterface',
            $serviceParam->getType()->getName()
        );
    }

    public function test_controller_has_validator_dependency(): void
    {
        $reflection = new \ReflectionClass(CreateGameController::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor, 'Controller should have a constructor');

        $params = $constructor->getParameters();

        // Find the validator parameter
        $validatorParam = null;
        foreach ($params as $param) {
            $type = $param->getType();
            if ($type instanceof \ReflectionNamedType &&
                str_contains($type->getName(), 'ValidatorInterface')) {
                $validatorParam = $param;
                break;
            }
        }

        $this->assertNotNull($validatorParam, 'Should have a validator dependency for body param');
        $this->assertEquals(
            'Symfony\Component\Validator\Validator\ValidatorInterface',
            $validatorParam->getType()->getName()
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
}
