<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Http\Requests\CreateGameRequest;
use LaravelMaxApi\Models\CreateGameRequestDto;
use Illuminate\Http\JsonResponse;

/**
 * GameController
 *
 * Auto-generated controller for Game API operations
 * Handles HTTP layer and delegates to business logic Handler
 *
 * RESPONSIBILITIES:
 * - Route handling
 * - Request validation (via FormRequest)
 * - DTO conversion
 * - Delegation to Handler
 * - Resource response (Handler sets httpCode and headers)
 *
 * PSR-4 COMPLIANT: One class per file
 *
 * Note: No base Controller class needed in modern Laravel
 */
class GameController
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
     * Create a new game
     *
     * OpenAPI operation: createGame
     * HTTP Method: POST /games
     *
     * FLOW:
     * 1. CreateGameRequest validates input (rules from OpenAPI schema)
     * 2. Controller converts validated data to DTO
     * 3. Handler executes business logic
     * 4. Handler returns Resource with $httpCode and headers set
     * 5. Resource->withResponse() enforces status code and headers
     *
     * @param CreateGameRequest $request Auto-validated request
     * @return JsonResponse GameResource (201) | ValidationErrorResource (422) | UnauthorizedErrorResource (401)
     */
    public function createGame(CreateGameRequest $request): JsonResponse
    {
        // Convert validated data to typed DTO
        $dto = CreateGameRequestDto::fromArray($request->validated());

        // Delegate to Handler - Handler MUST set $httpCode and required headers
        $resource = $this->handler->createGame($dto);

        // Resource->withResponse() enforces:
        // - HTTP status code is set
        // - Required headers are present (e.g., Location for 201)
        return $resource->response($request);
    }

    /**
     * Get game details
     *
     * OpenAPI operation: getGame
     * HTTP Method: GET /games/{gameId}
     *
     * FLOW:
     * 1. Route parameter binding provides $gameId
     * 2. Handler fetches game (or returns error Resource)
     * 3. Handler returns Resource with $httpCode set
     * 4. Resource->withResponse() enforces status code
     *
     * @param string $gameId Unique game identifier from route parameter
     * @return JsonResponse GameResource (200) | ValidationErrorResource (422)
     */
    public function getGame(string $gameId): JsonResponse
    {
        // Delegate to Handler - Handler MUST set $httpCode
        $resource = $this->handler->getGame($gameId);

        // Resource->withResponse() enforces HTTP status code is set
        // Note: GET operations typically don't have special headers
        return $resource->response(request());
    }
}
