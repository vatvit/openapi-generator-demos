<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * CreateGameRequest
 *
 * Auto-generated Laravel FormRequest from OpenAPI specification
 * Validates request data for createGame operation
 *
 * Request body schema: CreateGameRequest
 * - mode: string (required) - Game mode: "single-player" | "two-player"
 * - playerXId: string (required) - Player X identifier
 * - playerOId: string (optional) - Player O identifier (required for two-player)
 */
class CreateGameRequest extends FormRequest
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
            // mode: required, enum values from OpenAPI spec
            'mode' => [
                'required',
                'string',
                'in:single-player,two-player'
            ],

            // playerXId: required, string
            'playerXId' => [
                'required',
                'string',
                'max:255'
            ],

            // playerOId: optional for single-player, required for two-player
            'playerOId' => [
                'nullable',
                'string',
                'max:255',
                'required_if:mode,two-player' // Conditional validation
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
            'mode.required' => 'Game mode is required',
            'mode.in' => 'Game mode must be either single-player or two-player',
            'playerXId.required' => 'Player X ID is required',
            'playerOId.required_if' => 'Player O ID is required for two-player games',
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
