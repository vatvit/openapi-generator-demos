<?php

declare(strict_types=1);

namespace PetshopApi\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class AddPetFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;  // Authorization logic should be implemented in middleware
    }

    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'tag' => ['sometimes', 'string'],
        ];
    }
}
