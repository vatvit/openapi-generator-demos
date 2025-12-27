<?php

declare(strict_types=1);

namespace LaravelMaxApi\Api;

use LaravelMaxApi\Models\CreateGameRequestDto;
use LaravelMaxApi\Http\Resources\CreateGame201Resource;
use LaravelMaxApi\Http\Resources\GetGame200Resource;
use LaravelMaxApi\Http\Resources\ValidationErrorResource;
use LaravelMaxApi\Http\Resources\UnauthorizedErrorResource;

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
     * @return CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
     *
     * RESPONSE CONTRACT:
     * Return one of these Resources (each enforces its own HTTP code and structure):
     *
     * Success (201 Created):
     *   $resource = new CreateGame201Resource($game);
     *   $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED header
     *   return $resource;
     *
     * Validation Error (422):
     *   $resource = new ValidationErrorResource($errors);
     *   return $resource;
     *
     * Unauthorized (401):
     *   $resource = new UnauthorizedErrorResource($error);
     *   return $resource;
     */
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource;

    /**
     * Get game details
     *
     * OpenAPI operation: getGame
     * HTTP Method: GET /games/{gameId}
     *
     * @param string $gameId Unique game identifier
     * @return GetGame200Resource|ValidationErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (200 OK):
     *   $resource = new GetGame200Resource($game);
     *   return $resource;
     *   // Note: No Location header for GET operations
     *
     * Not Found (404):
     *   $resource = new NotFoundErrorResource($error);
     *   return $resource;
     */
    public function getGame(string $gameId): GetGame200Resource|ValidationErrorResource;
}
