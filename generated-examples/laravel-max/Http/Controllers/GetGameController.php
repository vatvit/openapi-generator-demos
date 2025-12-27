<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use Illuminate\Http\JsonResponse;

/**
 * GetGameController
 *
 * Auto-generated controller for getGame operation
 * One controller per operation pattern
 *
 * RESPONSIBILITIES:
 * - Route handling for GET /games/{gameId}
 * - Path parameter binding
 * - Delegation to GameApi handler
 * - Resource response
 *
 * PSR-4 COMPLIANT: One class per file
 */
class GetGameController
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
     * @return JsonResponse GetGame200Resource (200) | ValidationErrorResource (422) | NotFoundErrorResource (404)
     */
    public function __invoke(string $gameId): JsonResponse
    {
        // Delegate to Handler - Handler MUST set $httpCode
        $resource = $this->handler->getGame($gameId);

        // Resource->withResponse() enforces HTTP status code is set
        // Note: GET operations typically don't have special headers
        return $resource->response(request());
    }
}
