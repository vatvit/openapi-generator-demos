<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\GameMode;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tests for generated Model DTOs (Symfony) with Validator attributes
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

        // Note: php-max uses camelCase for property names
        $expectedProperties = ['id', 'status', 'mode', 'board', 'createdAt'];

        foreach ($expectedProperties as $property) {
            $this->assertTrue(
                $reflection->hasProperty($property),
                "Game should have property: $property"
            );
        }
    }

    public function test_game_id_has_uuid_validation(): void
    {
        $reflection = new \ReflectionClass(Game::class);
        $property = $reflection->getProperty('id');
        $attributes = $property->getAttributes();

        $hasUuidAttribute = false;
        foreach ($attributes as $attr) {
            if ($attr->getName() === Assert\Uuid::class) {
                $hasUuidAttribute = true;
                break;
            }
        }

        $this->assertTrue($hasUuidAttribute, 'Game id should have Uuid validation attribute');
    }

    public function test_game_has_not_blank_validation(): void
    {
        $reflection = new \ReflectionClass(Game::class);
        $property = $reflection->getProperty('id');
        $attributes = $property->getAttributes();

        $hasNotBlankAttribute = false;
        foreach ($attributes as $attr) {
            if ($attr->getName() === Assert\NotBlank::class) {
                $hasNotBlankAttribute = true;
                break;
            }
        }

        $this->assertTrue($hasNotBlankAttribute, 'Game id should have NotBlank validation attribute');
    }

    public function test_game_has_from_array_method(): void
    {
        $reflection = new \ReflectionClass(Game::class);

        $this->assertTrue(
            $reflection->hasMethod('fromArray'),
            'Game should have fromArray static method'
        );

        $method = $reflection->getMethod('fromArray');
        $this->assertTrue($method->isStatic(), 'fromArray should be static');
        $this->assertTrue($method->isPublic(), 'fromArray should be public');
    }

    public function test_game_has_to_array_method(): void
    {
        $reflection = new \ReflectionClass(Game::class);

        $this->assertTrue(
            $reflection->hasMethod('toArray'),
            'Game should have toArray method'
        );

        $method = $reflection->getMethod('toArray');
        $this->assertTrue($method->isPublic(), 'toArray should be public');
    }

    public function test_create_game_request_has_mode_property(): void
    {
        $reflection = new \ReflectionClass(CreateGameRequest::class);

        $this->assertTrue(
            $reflection->hasProperty('mode'),
            'CreateGameRequest should have mode property'
        );
    }

    public function test_game_status_enum_has_expected_cases(): void
    {
        $cases = GameStatus::cases();

        $this->assertNotEmpty($cases, 'GameStatus should have enum cases');

        $caseNames = array_map(fn($case) => $case->name, $cases);
        $this->assertContains('PENDING', $caseNames);
        $this->assertContains('IN_PROGRESS', $caseNames);
        $this->assertContains('COMPLETED', $caseNames);
    }

    public function test_game_mode_enum_has_expected_cases(): void
    {
        $cases = GameMode::cases();

        $this->assertNotEmpty($cases, 'GameMode should have enum cases');

        $caseNames = array_map(fn($case) => $case->name, $cases);
        $this->assertContains('PVP', $caseNames);
        $this->assertContains('AI_EASY', $caseNames);
    }
}
