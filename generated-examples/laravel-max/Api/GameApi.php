<?php

declare(strict_types=1);

namespace LaravelMaxApi\Api;

use LaravelMaxApi\Models\CreateGameRequestDto;
use LaravelMaxApi\Models\GameListQueryParams;
use LaravelMaxApi\Models\MoveRequestDto;
use LaravelMaxApi\Http\Resources\CreateGame201Resource;
use LaravelMaxApi\Http\Resources\GetGame200Resource;
use LaravelMaxApi\Http\Resources\ListGames200Resource;
use LaravelMaxApi\Http\Resources\DeleteGame204Resource;
use LaravelMaxApi\Http\Resources\GetBoard200Resource;
use LaravelMaxApi\Http\Resources\PutSquare200Resource;
use LaravelMaxApi\Http\Resources\ValidationErrorResource;
use LaravelMaxApi\Http\Resources\UnauthorizedErrorResource;
use LaravelMaxApi\Http\Resources\ForbiddenErrorResource;
use LaravelMaxApi\Http\Resources\NotFoundErrorResource;
use LaravelMaxApi\Http\Resources\ConflictErrorResource;

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
     * @return GetGame200Resource|ValidationErrorResource|NotFoundErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (200 OK):
     *   $resource = new GetGame200Resource($game);
     *   return $resource;
     *   // Note: No Location header for GET operations
     *
     * Not Found (404):
     *   $resource = new NotFoundErrorResource(['message' => 'Game not found']);
     *   return $resource;
     */
    public function getGame(string $gameId): GetGame200Resource|ValidationErrorResource|NotFoundErrorResource;

    /**
     * List all games
     *
     * OpenAPI operation: list-games
     * HTTP Method: GET /games
     *
     * @param GameListQueryParams $query Query parameters (page, limit, status, playerXId)
     * @return ListGames200Resource|ValidationErrorResource|UnauthorizedErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (200 OK):
     *   $resource = new ListGames200Resource($games);
     *   $resource->xTotalCount = $totalCount; // REQUIRED
     *   $resource->xPageNumber = $page; // OPTIONAL
     *   $resource->xPageSize = $limit; // OPTIONAL
     *   return $resource;
     */
    public function listGames(GameListQueryParams $query): ListGames200Resource|ValidationErrorResource|UnauthorizedErrorResource;

    /**
     * Delete a game
     *
     * OpenAPI operation: delete-game
     * HTTP Method: DELETE /games/{gameId}
     *
     * @param string $gameId Unique game identifier
     * @return DeleteGame204Resource|ForbiddenErrorResource|NotFoundErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (204 No Content):
     *   return new DeleteGame204Resource(null);
     *   // Note: 204 responses have empty body
     *
     * Forbidden (403):
     *   return new ForbiddenErrorResource(['message' => 'You do not own this game']);
     *
     * Not Found (404):
     *   return new NotFoundErrorResource(['message' => 'Game not found']);
     */
    public function deleteGame(string $gameId): DeleteGame204Resource|ForbiddenErrorResource|NotFoundErrorResource;

    /**
     * Get game board
     *
     * OpenAPI operation: get-board
     * HTTP Method: GET /games/{gameId}/board
     *
     * @param string $gameId Unique game identifier
     * @return GetBoard200Resource|NotFoundErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (200 OK):
     *   return new GetBoard200Resource($board);
     *
     * Not Found (404):
     *   return new NotFoundErrorResource(['message' => 'Game not found']);
     */
    public function getBoard(string $gameId): GetBoard200Resource|NotFoundErrorResource;

    /**
     * Place a mark on the board
     *
     * OpenAPI operation: put-square
     * HTTP Method: PUT /games/{gameId}/board/{row}/{column}
     *
     * @param string $gameId Unique game identifier
     * @param int $row Board row (1-3)
     * @param int $column Board column (1-3)
     * @param MoveRequestDto $request Move data (mark: X or O)
     * @return PutSquare200Resource|ValidationErrorResource|NotFoundErrorResource|ConflictErrorResource
     *
     * RESPONSE CONTRACT:
     *
     * Success (200 OK):
     *   return new PutSquare200Resource($board);
     *
     * Not Found (404):
     *   return new NotFoundErrorResource(['message' => 'Game not found']);
     *
     * Conflict (409):
     *   return new ConflictErrorResource(['message' => 'Square already occupied']);
     */
    public function putSquare(string $gameId, int $row, int $column, MoveRequestDto $request): PutSquare200Resource|ValidationErrorResource|NotFoundErrorResource|ConflictErrorResource;
}
