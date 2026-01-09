<?php

declare(strict_types=1);

namespace TicTacToeApi\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * ListGamesRequest
 *
 * Form request for listGames operation.
 * List all games
 */
final class ListGamesRequest extends FormRequest
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
            'page' => ['nullable', 'integer'],
            'limit' => ['nullable', 'integer'],
            'status' => ['nullable'],
            'playerId' => ['nullable', 'string'],
        ];
    }

}
