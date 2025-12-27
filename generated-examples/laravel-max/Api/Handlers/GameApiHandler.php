<?php

declare(strict_types=1);

namespace App\Api\Handlers;

use App\Api\GameApi;
use App\Models\CreateGameRequestDto;
use App\Models\Game;
use App\Http\Resources\GameResource;
use App\Http\Resources\ValidationErrorResource;
use App\Http\Resources\UnauthorizedErrorResource;

/**
 * GameApiHandler
 *
 * EXAMPLE implementation of GameApi interface
 * Developer writes business logic here
 *
 * This is NOT auto-generated - developer implements this class
 */
class GameApiHandler implements GameApi
{
    /**
     * Create a new game
     *
     * @param CreateGameRequestDto $request Typed, validated request data
     * @return GameResource|ValidationErrorResource|UnauthorizedErrorResource
     */
    public function createGame(CreateGameRequestDto $request): GameResource|ValidationErrorResource|UnauthorizedErrorResource
    {
        // Business logic: Create game
        // (In real app: save to database, validate players exist, etc.)
        $game = new Game(
            id: 'game_' . uniqid(),
            status: 'waiting',
            mode: $request->mode,
            playerXId: $request->playerXId,
            playerOId: $request->playerOId,
            currentTurn: 'X',
            winner: null,
            createdAt: new \DateTime(),
            updatedAt: new \DateTime(),
        );

        // Return GameResource with 201 Created
        $resource = new GameResource($game);
        $resource->httpCode = 201; // REQUIRED
        $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED for 201

        return $resource;
    }

    /**
     * Get game details
     *
     * @param string $gameId
     * @return GameResource|ValidationErrorResource
     */
    public function getGame(string $gameId): GameResource|ValidationErrorResource
    {
        // Business logic: Fetch game from database
        // (In real app: query database, handle not found, etc.)

        // Example: Mock game data
        $game = new Game(
            id: $gameId,
            status: 'in-progress',
            mode: 'two-player',
            playerXId: 'player1',
            playerOId: 'player2',
            currentTurn: 'O',
            winner: null,
            createdAt: new \DateTime('2025-01-01'),
            updatedAt: new \DateTime(),
        );

        // Return GameResource with 200 OK
        $resource = new GameResource($game);
        $resource->httpCode = 200; // REQUIRED
        // Note: No Location header for GET

        return $resource;
    }
}
