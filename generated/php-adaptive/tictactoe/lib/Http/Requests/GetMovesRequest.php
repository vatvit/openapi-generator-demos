<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * GetMovesRequest
 *
 * Form request for getMoves operation.
 * Get move history
 */
final class GetMovesRequest extends FormRequest
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
        ];
    }

}
