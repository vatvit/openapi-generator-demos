<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * ListGamesRequest
 *
 * Auto-generated Laravel FormRequest from OpenAPI specification
 * Validates query parameters for list-games operation
 *
 * Query parameters:
 * - page: integer (optional, default: 1) - Page number for pagination
 * - limit: integer (optional, default: 20) - Number of items per page
 * - status: string (optional) - Filter by game status (waiting|in-progress|completed)
 * - playerXId: string (optional) - Filter by Player X identifier
 */
class ListGamesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Authorization handled by middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * Rules auto-generated from OpenAPI schema
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // page: optional, integer, minimum 1
            'page' => [
                'sometimes',
                'integer',
                'min:1'
            ],

            // limit: optional, integer, between 1 and 100
            'limit' => [
                'sometimes',
                'integer',
                'min:1',
                'max:100'
            ],

            // status: optional, enum values from OpenAPI spec
            'status' => [
                'sometimes',
                'string',
                'in:waiting,in-progress,completed'
            ],

            // playerXId: optional, string
            'playerXId' => [
                'sometimes',
                'string',
                'max:255'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'page.integer' => 'Page number must be an integer',
            'page.min' => 'Page number must be at least 1',
            'limit.integer' => 'Limit must be an integer',
            'limit.min' => 'Limit must be at least 1',
            'limit.max' => 'Limit cannot exceed 100',
            'status.in' => 'Status must be one of: waiting, in-progress, completed',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * Returns 422 with ValidationError structure from OpenAPI spec
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Validation Error',
                'message' => 'The request data is invalid',
                'errors' => $validator->errors()->toArray()
            ], 422)
        );
    }
}
