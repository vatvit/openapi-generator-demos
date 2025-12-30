<?php

namespace Tests\Feature;

use TictactoeApi\Http\Requests\PutSquareFormRequest;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Validator;

/**
 * Integration test for PutSquareFormRequest
 *
 * Verifies enum validation rules extracted from OpenAPI schema
 */
class PutSquareFormRequestTest extends TestCase
{
    /**
     * Test valid mark 'X' passes validation
     */
    public function test_valid_mark_x_passes(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        $data = ['mark' => 'X'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->fails(),
            'Valid mark X should pass validation');
    }

    /**
     * Test valid mark 'O' passes validation
     */
    public function test_valid_mark_o_passes(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        $data = ['mark' => 'O'];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->fails(),
            'Valid mark O should pass validation');
    }

    /**
     * Test invalid enum value fails validation
     */
    public function test_invalid_enum_value_fails(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        // Invalid enum value
        $data = ['mark' => 'Z'];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails(),
            'Invalid enum value should fail validation');
        $this->assertTrue($validator->errors()->has('mark'),
            'Should have error for mark field');
    }

    /**
     * Test missing required field fails validation
     */
    public function test_missing_required_field_fails(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        $data = [];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails(),
            'Missing required field should fail validation');
        $this->assertTrue($validator->errors()->has('mark'),
            'Should have error for mark field');
    }

    /**
     * Test validation rules extracted correctly from OpenAPI
     */
    public function test_validation_rules_match_schema(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        // Verify 'mark' is required
        $this->assertContains('required', $rules['mark'],
            'mark should be required');

        // Verify 'mark' is string
        $this->assertContains('string', $rules['mark'],
            'mark should be string type');

        // Verify 'mark' has enum validation for X and O
        $this->assertContains('in:X,O', $rules['mark'],
            'mark should have enum validation for X and O');
    }

    /**
     * Test case sensitivity in enum validation
     */
    public function test_lowercase_enum_value_fails(): void
    {
        $formRequest = new PutSquareFormRequest();
        $rules = $formRequest->rules();

        // Lowercase should fail (enum values are case-sensitive)
        $data = ['mark' => 'x'];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails(),
            'Lowercase enum value should fail validation (case-sensitive)');
    }
}
