<?php

declare(strict_types=1);

namespace TictactoeApi\Api\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PutSquareFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;  // Authorization logic should be implemented in middleware
    }

    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'mark' => ['required', 'string', 'in:X,O'],
        ];
    }
}
