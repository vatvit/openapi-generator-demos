<?php

declare(strict_types=1);

namespace PetshopApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * AddPetRequest
 *
 * Form request for addPet operation.
 */
final class AddPetRequest extends FormRequest
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
            'tag' => ['nullable', 'string'],
        ];
    }

    /**
     * Get validated data suitable for creating a DTO.
     *
     * @return array<string, mixed>
     */
    public function validated($key = null, $default = null): mixed
    {
        return parent::validated($key, $default);
    }
}
