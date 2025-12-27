<?php

declare(strict_types=1);

namespace LaravelMaxApi\Http\Controllers;

use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Http\Requests\CreateGameRequest;
use LaravelMaxApi\Models\CreateGameRequestDto;
use Illuminate\Http\JsonResponse;

/**
 * CreateGameController
 *
 * Auto-generated controller for createGame operation
 * One controller per operation pattern - easier to generate, better separation of concerns
 *
 * ADVANTAGES OF ONE CONTROLLER PER OPERATION:
 * - Each controller is focused on a single responsibility
 * - Easier to generate from OpenAPI spec (1:1 mapping operation -> controller)
 * - Simpler testing (one test file per controller)
 * - Better code organization and discoverability
 * - No routing confusion (clear which controller handles which operation)
 * - Each controller can have operation-specific dependencies
 *
 * RESPONSIBILITIES:
 * - Route handling for POST /games
 * - Request validation (via CreateGameRequest FormRequest)
 * - DTO conversion
 * - Delegation to GameApi handler
 * - Resource response (Handler sets httpCode and headers)
 *
 * PSR-4 COMPLIANT: One class per file
 *
 * Note: No base Controller class needed in modern Laravel
 */
class CreateGameController
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
     * @return JsonResponse CreateGame201Resource (201) | ValidationErrorResource (422) | UnauthorizedErrorResource (401)
     */
    public function __invoke(CreateGameRequest $request): JsonResponse
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
}
