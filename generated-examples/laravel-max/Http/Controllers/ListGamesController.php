<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Http\Requests\ListGamesRequest;
use LaravelMaxApi\Models\GameListQueryParams;
use Illuminate\Http\JsonResponse;

/**
 * ListGamesController
 *
 * Auto-generated controller for list-games operation
 * One controller per operation pattern
 *
 * RESPONSIBILITIES:
 * - Route handling for GET /games
 * - Query parameter validation (via ListGamesRequest FormRequest)
 * - Query params to DTO conversion
 * - Delegation to GameApi handler
 * - ResourceCollection response with pagination headers
 *
 * PSR-4 COMPLIANT: One class per file
 */
class ListGamesController
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
     * List all games
     *
     * OpenAPI operation: list-games
     * HTTP Method: GET /games
     *
     * FLOW:
     * 1. ListGamesRequest validates query parameters
     * 2. Controller converts query params to GameListQueryParams DTO
     * 3. Handler executes query with pagination and filters
     * 4. Handler returns ListGames200Resource with pagination headers
     * 5. Resource->withResponse() enforces X-Total-Count header
     *
     * @param ListGamesRequest $request Auto-validated request with query params
     * @return JsonResponse ListGames200Resource (200) | ValidationErrorResource (422) | UnauthorizedErrorResource (401)
     */
    public function __invoke(ListGamesRequest $request): JsonResponse
    {
        // Convert validated query parameters to typed DTO
        $queryParams = GameListQueryParams::fromQuery($request->validated());

        // Delegate to Handler - Handler MUST set X-Total-Count header
        $resource = $this->handler->listGames($queryParams);

        // Resource->withResponse() enforces:
        // - HTTP 200 status code
        // - X-Total-Count header is present (REQUIRED)
        // - X-Page-Number and X-Page-Size headers (OPTIONAL)
        return $resource->response($request);
    }
}
