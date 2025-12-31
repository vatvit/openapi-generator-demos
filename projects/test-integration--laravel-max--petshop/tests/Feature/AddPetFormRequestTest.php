<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use TictactoeApi\Api\Http\Requests\AddPetFormRequest;

/**
 * Tests for generated AddPetFormRequest
 *
 * Validates that the generator produces proper Laravel FormRequest classes
 */
class AddPetFormRequestTest extends TestCase
{
    public function test_form_request_class_exists(): void
    {
        $this->assertTrue(
            class_exists(AddPetFormRequest::class),
            'AddPetFormRequest class should exist'
        );
    }

    public function test_extends_laravel_form_request(): void
    {
        $reflection = new ReflectionClass(AddPetFormRequest::class);
        $parent = $reflection->getParentClass();

        $this->assertNotFalse($parent, 'Should have a parent class');
        $this->assertEquals(
            'Illuminate\Foundation\Http\FormRequest',
            $parent->getName(),
            'Should extend Laravel FormRequest'
        );
    }

    public function test_has_rules_method(): void
    {
        $reflection = new ReflectionClass(AddPetFormRequest::class);
        $this->assertTrue(
            $reflection->hasMethod('rules'),
            'Should have rules() method'
        );
    }

    public function test_has_authorize_method(): void
    {
        $reflection = new ReflectionClass(AddPetFormRequest::class);
        $this->assertTrue(
            $reflection->hasMethod('authorize'),
            'Should have authorize() method'
        );
    }

    public function test_rules_returns_array(): void
    {
        $formRequest = new AddPetFormRequest();
        $rules = $formRequest->rules();

        $this->assertIsArray($rules, 'rules() should return an array');
    }

    public function test_rules_contain_required_fields(): void
    {
        $formRequest = new AddPetFormRequest();
        $rules = $formRequest->rules();

        $this->assertArrayHasKey('name', $rules, 'Rules should contain "name" field');
        $this->assertContains('required', $rules['name'], 'name field should be required');
        $this->assertContains('string', $rules['name'], 'name field should be string type');
    }

    public function test_rules_contain_optional_fields(): void
    {
        $formRequest = new AddPetFormRequest();
        $rules = $formRequest->rules();

        $this->assertArrayHasKey('tag', $rules, 'Rules should contain "tag" field');
        $this->assertContains('sometimes', $rules['tag'], 'tag field should be optional');
    }
}
