<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Api\GameManagementApiServiceInterface;
use TictactoeApi\Api\GameplayApiServiceInterface;
use TictactoeApi\Api\StatisticsApiServiceInterface;
use TictactoeApi\Api\TicTacApiServiceInterface;

/**
 * Tests for generated Service Interfaces (Symfony)
 *
 * php-max generator uses per-TAG service interfaces (not per-operation).
 * Each tag gets one interface containing all operations for that tag.
 */
class ServiceInterfaceTest extends TestCase
{
    public function test_all_service_interfaces_exist(): void
    {
        $interfaces = [
            GameManagementApiServiceInterface::class,
            GameplayApiServiceInterface::class,
            StatisticsApiServiceInterface::class,
            TicTacApiServiceInterface::class,
        ];

        foreach ($interfaces as $interface) {
            $this->assertTrue(
                interface_exists($interface),
                "Interface should exist: $interface"
            );
        }
    }

    public function test_game_management_service_has_crud_methods(): void
    {
        $reflection = new \ReflectionClass(GameManagementApiServiceInterface::class);

        // createGame
        $this->assertTrue(
            $reflection->hasMethod('createGame'),
            'GameManagementApiServiceInterface should have createGame method'
        );

        // getGame
        $this->assertTrue(
            $reflection->hasMethod('getGame'),
            'GameManagementApiServiceInterface should have getGame method'
        );

        // deleteGame
        $this->assertTrue(
            $reflection->hasMethod('deleteGame'),
            'GameManagementApiServiceInterface should have deleteGame method'
        );

        // listGames
        $this->assertTrue(
            $reflection->hasMethod('listGames'),
            'GameManagementApiServiceInterface should have listGames method'
        );
    }

    public function test_gameplay_service_has_game_methods(): void
    {
        $reflection = new \ReflectionClass(GameplayApiServiceInterface::class);

        // putSquare
        $this->assertTrue(
            $reflection->hasMethod('putSquare'),
            'GameplayApiServiceInterface should have putSquare method'
        );

        // getBoard
        $this->assertTrue(
            $reflection->hasMethod('getBoard'),
            'GameplayApiServiceInterface should have getBoard method'
        );

        // getMoves
        $this->assertTrue(
            $reflection->hasMethod('getMoves'),
            'GameplayApiServiceInterface should have getMoves method'
        );

        // getSquare
        $this->assertTrue(
            $reflection->hasMethod('getSquare'),
            'GameplayApiServiceInterface should have getSquare method'
        );
    }

    public function test_statistics_service_has_stats_methods(): void
    {
        $reflection = new \ReflectionClass(StatisticsApiServiceInterface::class);

        // getLeaderboard
        $this->assertTrue(
            $reflection->hasMethod('getLeaderboard'),
            'StatisticsApiServiceInterface should have getLeaderboard method'
        );

        // getPlayerStats
        $this->assertTrue(
            $reflection->hasMethod('getPlayerStats'),
            'StatisticsApiServiceInterface should have getPlayerStats method'
        );
    }

    public function test_create_game_method_signature(): void
    {
        $reflection = new \ReflectionClass(GameManagementApiServiceInterface::class);
        $method = $reflection->getMethod('createGame');
        $params = $method->getParameters();

        $this->assertCount(1, $params, 'createGame should have one parameter');
        $this->assertEquals('create_game_request', $params[0]->getName());
    }

    public function test_get_game_method_signature(): void
    {
        $reflection = new \ReflectionClass(GameManagementApiServiceInterface::class);
        $method = $reflection->getMethod('getGame');
        $params = $method->getParameters();

        $this->assertCount(1, $params, 'getGame should have one parameter');
        $this->assertEquals('game_id', $params[0]->getName());
    }

    public function test_put_square_method_signature(): void
    {
        $reflection = new \ReflectionClass(GameplayApiServiceInterface::class);
        $method = $reflection->getMethod('putSquare');
        $params = $method->getParameters();

        // Should have game_id, row, column, and body param
        $this->assertGreaterThanOrEqual(3, count($params));
    }

    public function test_service_interfaces_are_actually_interfaces(): void
    {
        $interfaces = [
            GameManagementApiServiceInterface::class,
            GameplayApiServiceInterface::class,
        ];

        foreach ($interfaces as $interface) {
            $reflection = new \ReflectionClass($interface);
            $this->assertTrue(
                $reflection->isInterface(),
                "$interface should be an interface"
            );
        }
    }
}
