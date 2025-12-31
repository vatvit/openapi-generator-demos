<?php

namespace Tests\Feature\Tictactoe;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Api\Http\Requests\CreateGameFormRequest;

/**
 * Tests for generated CreateGameFormRequest
 */
class CreateGameFormRequestTest extends TestCase
{
    public function test_form_request_class_exists(): void
    {
        $this->assertTrue(
            class_exists(CreateGameFormRequest::class),
            'CreateGameFormRequest class should exist'
        );
    }

    public function test_extends_laravel_form_request(): void
    {
        $reflection = new ReflectionClass(CreateGameFormRequest::class);
        $parent = $reflection->getParentClass();

        $this->assertNotFalse($parent);
        $this->assertEquals('Illuminate\Foundation\Http\FormRequest', $parent->getName());
    }

    public function test_has_rules_method(): void
    {
        $reflection = new ReflectionClass(CreateGameFormRequest::class);
        $this->assertTrue($reflection->hasMethod('rules'));
    }

    public function test_has_authorize_method(): void
    {
        $reflection = new ReflectionClass(CreateGameFormRequest::class);
        $this->assertTrue($reflection->hasMethod('authorize'));
    }

    public function test_rules_returns_array(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        $this->assertIsArray($rules);
    }

    public function test_rules_contain_required_mode(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        $this->assertArrayHasKey('mode', $rules);
        $this->assertContains('required', $rules['mode']);
    }

    public function test_rules_contain_optional_fields(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        $this->assertArrayHasKey('opponentId', $rules);
        $this->assertContains('sometimes', $rules['opponentId']);
    }
}
