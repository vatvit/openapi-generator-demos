<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Api\Http\Requests\PutSquareFormRequest;

/**
 * Tests for generated PutSquareFormRequest
 */
class PutSquareFormRequestTest extends TestCase
{
    public function test_form_request_class_exists(): void
    {
        $this->assertTrue(
            class_exists(PutSquareFormRequest::class),
            'PutSquareFormRequest class should exist'
        );
    }

    public function test_extends_laravel_form_request(): void
    {
        $reflection = new ReflectionClass(PutSquareFormRequest::class);
        $parent = $reflection->getParentClass();

        $this->assertNotFalse($parent);
        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $parent->getName());
    }

    public function test_has_rules_method(): void
    {
        $reflection = new ReflectionClass(PutSquareFormRequest::class);
        $this->assertTrue($reflection->hasMethod('rules'));
    }

    public function test_rules_returns_array(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        // Type is already array<string, ...>, so just verify it's not empty
        $this->assertNotEmpty($rules);
    }

    public function test_rules_contain_required_mark(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        $this->assertArrayHasKey('mark', $rules);
        $this->assertContains('required', $rules['mark']);
    }

    public function test_rules_contain_enum_validation(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        $this->assertArrayHasKey('mark', $rules);
        $this->assertContains('in:X,O', $rules['mark']);
    }
}
