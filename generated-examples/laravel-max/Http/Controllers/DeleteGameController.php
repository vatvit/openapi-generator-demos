<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use Illuminate\Http\JsonResponse;

/**
 * DeleteGameController
 *
 * Auto-generated controller for delete-game operation
 * One controller per operation pattern
 *
 * RESPONSIBILITIES:
 * - Route handling for DELETE /games/{gameId}
 * - Path parameter binding
 * - Delegation to GameApi handler
 * - 204 No Content response (empty body)
 *
 * PSR-4 COMPLIANT: One class per file
 */
class DeleteGameController
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
     * Delete a game
     *
     * OpenAPI operation: delete-game
     * HTTP Method: DELETE /games/{gameId}
     *
     * FLOW:
     * 1. Route parameter binding provides $gameId
     * 2. Handler checks permissions and deletes game
     * 3. Handler returns DeleteGame204Resource (empty body)
     * 4. Resource->withResponse() enforces HTTP 204 with empty content
     *
     * @param string $gameId Unique game identifier from route parameter
     * @return JsonResponse DeleteGame204Resource (204) | ForbiddenErrorResource (403) | NotFoundErrorResource (404)
     */
    public function __invoke(string $gameId): JsonResponse
    {
        // Delegate to Handler - Handler MUST return appropriate Resource
        $resource = $this->handler->deleteGame($gameId);

        // Resource->withResponse() enforces:
        // - HTTP 204 status code
        // - Empty response body
        return $resource->response(request());
    }
}
