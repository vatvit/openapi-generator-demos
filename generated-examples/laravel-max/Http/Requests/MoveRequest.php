<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * MoveRequest
 *
 * Auto-generated Laravel FormRequest from OpenAPI specification
 * Validates request data for put-square operation
 *
 * Request body schema: MoveRequest
 * - mark: string (required) - Mark to place: "X" | "O"
 */
class MoveRequest extends FormRequest
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
            // mark: required, enum values from OpenAPI spec
            'mark' => [
                'required',
                'string',
                'in:X,O'
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
            'mark.required' => 'Mark is required',
            'mark.in' => 'Mark must be either X or O',
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
