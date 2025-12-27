<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Http\Requests\MoveRequest;
use LaravelMaxApi\Models\MoveRequestDto;
use Illuminate\Http\JsonResponse;

/**
 * PutSquareController
 *
 * Auto-generated controller for put-square operation
 * One controller per operation pattern
 *
 * RESPONSIBILITIES:
 * - Route handling for PUT /games/{gameId}/board/{row}/{column}
 * - Path parameter binding (gameId, row, column)
 * - Request validation (via MoveRequest FormRequest)
 * - DTO conversion
 * - Delegation to GameApi handler
 * - Updated board state response
 *
 * PSR-4 COMPLIANT: One class per file
 */
class PutSquareController
{
    /**
     * Inject business logic handler via constructor
     *
     * @param GameApi $handler Business logic implementation
     */
    public function __construct(
        private readonly GameApi $handler
    ) {}

    /**
     * Place a mark on the board
     *
     * OpenAPI operation: put-square
     * HTTP Method: PUT /games/{gameId}/board/{row}/{column}
     *
     * FLOW:
     * 1. Route parameters provide $gameId, $row, $column
     * 2. MoveRequest validates request body (mark: X or O)
     * 3. Controller converts validated data to MoveRequestDto
     * 4. Handler validates move and updates board
     * 5. Handler returns PutSquare200Resource with updated board
     * 6. Resource->withResponse() enforces status code
     *
     * @param string $gameId Unique game identifier from route parameter
     * @param int $row Board row (1-3) from route parameter
     * @param int $column Board column (1-3) from route parameter
     * @param MoveRequest $request Auto-validated request with move data
     * @return JsonResponse PutSquare200Resource (200) | ValidationErrorResource (422) | NotFoundErrorResource (404) | ConflictErrorResource (409)
     */
    public function __invoke(string $gameId, int $row, int $column, MoveRequest $request): JsonResponse
    {
        // Convert validated data to typed DTO
        $moveDto = MoveRequestDto::fromArray($request->validated());

        // Delegate to Handler - Handler MUST validate move and return appropriate Resource
        $resource = $this->handler->putSquare($gameId, $row, $column, $moveDto);

        // Resource->withResponse() enforces HTTP status code is set
        return $resource->response($request);
    }
}
