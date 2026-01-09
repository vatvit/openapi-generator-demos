<?php

declare(strict_types=1);

namespace TictactoeApi\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * CreateGameFormRequest
 *
 * Form request validation for Create a new game
 *
 * @generated
 */
final class CreateGameFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization should be handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mode' => ['required'],
            'opponentId' => ['sometimes', 'string', 'uuid'],
            'isPrivate' => ['sometimes', 'boolean'],
            'metadata' => ['sometimes', ''],
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
            // Add custom error messages if needed
        ];
    }
}
