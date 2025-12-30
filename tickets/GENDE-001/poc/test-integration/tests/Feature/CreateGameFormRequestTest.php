<?php

namespace Tests\Feature;

use TictactoeApi\Http\Requests\CreateGameFormRequest;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Validator;

/**
 * Integration test for CreateGameFormRequest
 *
 * Verifies that validation rules extracted from OpenAPI schema work correctly
 */
class CreateGameFormRequestTest extends TestCase
{
    /**
     * Test valid request passes validation
     */
    public function test_valid_request_passes_validation(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        // Valid data matching OpenAPI schema
        $data = [
            'mode' => 'pvp',
            'opponentId' => '550e8400-e29b-41d4-a716-446655440000',
            'isPrivate' => true,
            'metadata' => ['key' => 'value'],
        ];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->fails(),
            'Valid request should pass validation. Errors: ' . json_encode($validator->errors()->all()));
    }

    /**
     * Test missing required field fails validation
     */
    public function test_missing_required_field_fails(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        // Missing required 'mode' field
        $data = [
            'opponentId' => '550e8400-e29b-41d4-a716-446655440000',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails(), 'Missing required field should fail validation');
        $this->assertTrue($validator->errors()->has('mode'), 'Should have error for mode field');
    }

    /**
     * Test invalid UUID format fails validation
     */
    public function test_invalid_uuid_format_fails(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        // Invalid UUID format
        $data = [
            'mode' => 'PVP',
            'opponentId' => 'not-a-uuid',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails(), 'Invalid UUID should fail validation');
        $this->assertTrue($validator->errors()->has('opponentId'), 'Should have error for opponentId field');
    }

    /**
     * Test invalid boolean type fails validation
     */
    public function test_invalid_boolean_type_fails(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        // Invalid boolean value
        $data = [
            'mode' => 'PVP',
            'isPrivate' => 'yes', // should be boolean
        ];

        $validator = Validator::make($data, $rules);

        $this->assertTrue($validator->fails(), 'Invalid boolean should fail validation');
        $this->assertTrue($validator->errors()->has('isPrivate'), 'Should have error for isPrivate field');
    }

    /**
     * Test optional fields can be omitted
     */
    public function test_optional_fields_can_be_omitted(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        // Only required field provided
        $data = [
            'mode' => 'pvp',
        ];

        $validator = Validator::make($data, $rules);

        $this->assertFalse($validator->fails(),
            'Request with only required fields should pass validation. Errors: ' . json_encode($validator->errors()->all()));
    }

    /**
     * Test validation rules match OpenAPI schema
     */
    public function test_validation_rules_match_schema(): void
    {
        $formRequest = new CreateGameFormRequest();
        $rules = $formRequest->rules();

        // Verify 'mode' is required
        $this->assertContains('required', $rules['mode'],
            'mode should be required per OpenAPI schema');

        // Verify 'opponentId' is optional with UUID validation
        $this->assertContains('sometimes', $rules['opponentId'],
            'opponentId should be optional (sometimes)');
        $this->assertContains('uuid', $rules['opponentId'],
            'opponentId should have UUID format validation');

        // Verify 'isPrivate' is optional boolean
        $this->assertContains('sometimes', $rules['isPrivate'],
            'isPrivate should be optional (sometimes)');
        $this->assertContains('boolean', $rules['isPrivate'],
            'isPrivate should have boolean type validation');

        // Verify 'metadata' is optional
        $this->assertContains('sometimes', $rules['metadata'],
            'metadata should be optional (sometimes)');
    }

    /**
     * Test authorize method
     */
    public function test_authorize_returns_true(): void
    {
        $formRequest = new CreateGameFormRequest();

        $this->assertTrue($formRequest->authorize(),
            'authorize() should return true by default');
    }
}
