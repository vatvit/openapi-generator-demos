<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\GameMode;

/**
 * Tests for generated TicTacToe Model DTOs (Slim)
 */
class ModelTest extends TestCase
{
    public function test_game_model_exists(): void
    {
        $this->assertTrue(
            class_exists(Game::class),
            'Game model class should exist'
        );
    }

    public function test_create_game_request_model_exists(): void
    {
        $this->assertTrue(
            class_exists(CreateGameRequest::class),
            'CreateGameRequest model class should exist'
        );
    }

    public function test_game_status_enum_exists(): void
    {
        $this->assertTrue(
            enum_exists(GameStatus::class),
            'GameStatus enum should exist'
        );
    }

    public function test_game_mode_enum_exists(): void
    {
        $this->assertTrue(
            enum_exists(GameMode::class),
            'GameMode enum should exist'
        );
    }

    public function test_game_has_required_properties(): void
    {
        $reflection = new \ReflectionClass(Game::class);

        // Based on actual generated properties
        $expectedProperties = ['id', 'status', 'mode'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Game should have property: $property"
            );
        }
    }

    public function test_game_status_enum_has_expected_cases(): void
    {
        $cases = GameStatus::cases();
        $caseNames = array_map(fn($case) => $case->name, $cases);

        // Enum cases are uppercase
        $this->assertContains('PENDING', $caseNames);
        $this->assertContains('IN_PROGRESS', $caseNames);
        $this->assertContains('COMPLETED', $caseNames);
    }

    public function test_game_mode_enum_has_expected_cases(): void
    {
        $cases = GameMode::cases();
        $caseNames = array_map(fn($case) => $case->name, $cases);

        // Enum cases are uppercase
        $this->assertContains('PVP', $caseNames);
        $this->assertContains('AI_EASY', $caseNames);
    }
}
