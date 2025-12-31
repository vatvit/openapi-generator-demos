<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use Illuminate\Http\JsonResponse;

/**
 * GetBoardController
 *
 * Auto-generated controller for get-board operation
 * One controller per operation pattern
 *
 * RESPONSIBILITIES:
 * - Route handling for GET /games/{gameId}/board
 * - Path parameter binding
 * - Delegation to GameApi handler
 * - Board state response
 *
 * PSR-4 COMPLIANT: One class per file
 */
class GetBoardController
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
     * Get game board
     *
     * OpenAPI operation: get-board
     * HTTP Method: GET /games/{gameId}/board
     *
     * FLOW:
     * 1. Route parameter binding provides $gameId
     * 2. Handler fetches current board state
     * 3. Handler returns GetBoard200Resource with board data
     * 4. Resource->withResponse() enforces status code
     *
     * @param string $gameId Unique game identifier from route parameter
     * @return JsonResponse GetBoard200Resource (200) | NotFoundErrorResource (404)
     */
    public function __invoke(string $gameId): JsonResponse
    {
        // Delegate to Handler - Handler MUST set $httpCode
        $resource = $this->handler->getBoard($gameId);

        // Resource->withResponse() enforces HTTP status code is set
        return $resource->response(request());
    }
}
