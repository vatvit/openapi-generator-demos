<?php

declare(strict_types=1);

namespace App\Api;

use App\Models\CreateGameRequestDto;
use App\Http\Resources\GameResource;
use App\Http\Resources\ValidationErrorResource;
use App\Http\Resources\UnauthorizedErrorResource;

/**
 * GameApi Interface
 *
 * Auto-generated from OpenAPI specification
 * Developer MUST implement this interface to provide business logic
 *
 * CONTRACT ENFORCEMENT:
 * - Typed parameters enforce request structure
 * - Typed return values enforce response structure
 * - Resource classes enforce HTTP status codes and headers
 * - Controller delegates to this interface
 */
interface GameApi
{
    /**
     * Create a new game
     *
     * OpenAPI operation: createGame
     * HTTP Method: POST /games
     *
     * @param CreateGameRequestDto $request Validated and typed request data
     * @return GameResource|ValidationErrorResource|UnauthorizedErrorResource
     *
     * RESPONSE CONTRACT:
     * Return one of these Resources (each enforces its own HTTP code and structure):
     *
     * Success (201 Created):
     *   $resource = new GameResource($game);
     *   $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED header
     *   $resource->httpCode = 201; // REQUIRED
     *   return $resource;
     *
     * Validation Error (422):
     *   $resource = new ValidationErrorResource($errors);
     *   $resource->httpCode = 422;
     *   return $resource;
     *
     * Unauthorized (401):
     *   $resource = new UnauthorizedErrorResource($error);
     *   $resource->httpCode = 401;
     *   return $resource;
     */
    public function createGame(CreateGameRequestDto $request): GameResource|ValidationErrorResource|UnauthorizedErrorResource;

    /**
     * Get game details
     *
     * OpenAPI operation: getGame
     * HTTP Method: GET /games/{gameId}
     *
     * @param string $gameId Unique game identifier
     * @return GameResource|UnauthorizedErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (200 OK):
     *   $resource = new GameResource($game);
     *   $resource->httpCode = 200; // REQUIRED
     *   return $resource;
     *   // Note: No Location header for GET operations
     *
     * Not Found (404):
     *   $resource = new NotFoundErrorResource($error);
     *   $resource->httpCode = 404;
     *   return $resource;
     */
    public function getGame(string $gameId): GameResource|ValidationErrorResource;
}
