<?php

declare(strict_types=1);

namespace PetshopApi\Request;

use Illuminate\Foundation\Http\FormRequest;

/**
 * AddPetFormRequest
 *
 * Form request validation for 
 *
 * @generated
 */
final class AddPetFormRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'tag' => ['sometimes', 'string'],
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
