<?php

declare(strict_types=1);

namespace TictactoeApi\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * PutSquareFormRequest
 *
 * Form request validation for Set a single board square
 *
 * @generated
 */
final class PutSquareFormRequest extends FormRequest
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
            'mark' => ['required', 'string', 'in:X,O'],
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
