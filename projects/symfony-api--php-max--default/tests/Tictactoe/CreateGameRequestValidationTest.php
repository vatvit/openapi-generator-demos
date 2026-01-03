<?php

declare(strict_types=1);

namespace App\Tests\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Api\Dto\CreateGameRequest;

/**
 * Tests for generated CreateGameRequest DTO validation
 *
 * Equivalent of Laravel FormRequest tests - validates Assert attributes
 */
class CreateGameRequestValidationTest extends TestCase
{
    public function test_dto_class_exists(): void
    {
        $this->assertTrue(
            class_exists(CreateGameRequest::class),
            'CreateGameRequest DTO class should exist'
        );
    }

    public function test_has_mode_property(): void
    {
        $reflection = new ReflectionClass(CreateGameRequest::class);
        $this->assertTrue(
            $reflection->hasProperty('mode'),
            'DTO should have mode property'
        );
    }

    public function test_mode_has_not_blank_attribute(): void
    {
        $reflection = new ReflectionClass(CreateGameRequest::class);
        $property = $reflection->getProperty('mode');
        $attributes = $property->getAttributes();

        $attributeNames = array_map(fn($attr) => $attr->getName(), $attributes);
        $this->assertContains(
            'Symfony\Component\Validator\Constraints\NotBlank',
            $attributeNames,
            'mode property should have NotBlank attribute'
        );
    }

    public function test_mode_has_choice_attribute(): void
    {
        $reflection = new ReflectionClass(CreateGameRequest::class);
        $property = $reflection->getProperty('mode');
        $attributes = $property->getAttributes();

        $attributeNames = array_map(fn($attr) => $attr->getName(), $attributes);
        $this->assertContains(
            'Symfony\Component\Validator\Constraints\Choice',
            $attributeNames,
            'mode property should have Choice attribute'
        );
    }

    public function test_mode_choice_includes_valid_values(): void
    {
        $reflection = new ReflectionClass(CreateGameRequest::class);
        $property = $reflection->getProperty('mode');
        $attributes = $property->getAttributes('Symfony\Component\Validator\Constraints\Choice');

        $this->assertNotEmpty($attributes, 'Should have Choice attribute');

        $choiceAttr = $attributes[0];
        $args = $choiceAttr->getArguments();

        $choices = is_array($args[0] ?? null) ? $args[0] : ($args['choices'] ?? []);
        $this->assertContains('pvp', $choices);
        $this->assertContains('ai_easy', $choices);
        $this->assertContains('ai_medium', $choices);
        $this->assertContains('ai_hard', $choices);
    }

    public function test_optional_opponent_id_has_type_attribute(): void
    {
        $reflection = new ReflectionClass(CreateGameRequest::class);
        $property = $reflection->getProperty('opponentId');
        $attributes = $property->getAttributes();

        $attributeNames = array_map(fn($attr) => $attr->getName(), $attributes);
        $this->assertContains(
            'Symfony\Component\Validator\Constraints\Type',
            $attributeNames,
            'opponentId property should have Type attribute'
        );
    }

    public function test_opponent_id_is_nullable(): void
    {
        $reflection = new ReflectionClass(CreateGameRequest::class);
        $property = $reflection->getProperty('opponentId');
        $type = $property->getType();

        $this->assertNotNull($type);
        $this->assertTrue($type->allowsNull(), 'opponentId should be nullable');
    }
}
