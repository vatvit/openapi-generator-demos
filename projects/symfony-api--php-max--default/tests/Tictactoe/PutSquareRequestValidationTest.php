<?php

declare(strict_types=1);

namespace App\Tests\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Api\Dto\PutSquareRequest;

/**
 * Tests for generated PutSquareRequest DTO validation
 *
 * Equivalent of Laravel FormRequest tests - validates Assert attributes
 */
class PutSquareRequestValidationTest extends TestCase
{
    public function test_dto_class_exists(): void
    {
        $this->assertTrue(
            class_exists(PutSquareRequest::class),
            'PutSquareRequest DTO class should exist'
        );
    }

    public function test_has_mark_property(): void
    {
        $reflection = new ReflectionClass(PutSquareRequest::class);
        $this->assertTrue(
            $reflection->hasProperty('mark'),
            'DTO should have mark property'
        );
    }

    public function test_mark_has_not_blank_attribute(): void
    {
        $reflection = new ReflectionClass(PutSquareRequest::class);
        $property = $reflection->getProperty('mark');
        $attributes = $property->getAttributes();

        $attributeNames = array_map(fn($attr) => $attr->getName(), $attributes);
        $this->assertContains(
            'Symfony\Component\Validator\Constraints\NotBlank',
            $attributeNames,
            'mark property should have NotBlank attribute'
        );
    }

    public function test_mark_has_type_attribute(): void
    {
        $reflection = new ReflectionClass(PutSquareRequest::class);
        $property = $reflection->getProperty('mark');
        $attributes = $property->getAttributes();

        $attributeNames = array_map(fn($attr) => $attr->getName(), $attributes);
        $this->assertContains(
            'Symfony\Component\Validator\Constraints\Type',
            $attributeNames,
            'mark property should have Type attribute'
        );
    }

    public function test_mark_has_choice_attribute_with_valid_values(): void
    {
        $reflection = new ReflectionClass(PutSquareRequest::class);
        $property = $reflection->getProperty('mark');
        $attributes = $property->getAttributes('Symfony\Component\Validator\Constraints\Choice');

        $this->assertNotEmpty($attributes, 'mark property should have Choice attribute');

        $choiceAttr = $attributes[0];
        $args = $choiceAttr->getArguments();

        $choices = is_array($args[0] ?? null) ? $args[0] : ($args['choices'] ?? []);
        $this->assertContains('X', $choices, 'Choice should include X');
        $this->assertContains('O', $choices, 'Choice should include O');
    }
}
