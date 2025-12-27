<?php

declare(strict_types=1);

namespace LaravelMaxApi\Api\Handlers;

use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Models\CreateGameRequestDto;
use LaravelMaxApi\Models\Game;
use LaravelMaxApi\Http\Resources\CreateGame201Resource;
use LaravelMaxApi\Http\Resources\GetGame200Resource;
use LaravelMaxApi\Http\Resources\ValidationErrorResource;
use LaravelMaxApi\Http\Resources\UnauthorizedErrorResource;

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
     * @return CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
     */
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
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

        // Return CreateGame201Resource with Location header
        $resource = new CreateGame201Resource($game);
        $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED for 201

        return $resource;
    }

    /**
     * Get game details
     *
     * @param string $gameId
     * @return GetGame200Resource|ValidationErrorResource
     */
    public function getGame(string $gameId): GetGame200Resource|ValidationErrorResource
    {
        // Business logic: Fetch game from database
        // (In real app: query database, handle not found, etc.)

        // Example: Validate gameId format
        if (empty($gameId) || strlen($gameId) < 3) {
            return new ValidationErrorResource([
                'message' => 'Invalid game ID',
                'errors' => [
                    'gameId' => ['The game ID must be at least 3 characters']
                ]
            ]);
        }

        // Example: Game not found scenario
        if (str_starts_with($gameId, 'notfound-')) {
            return new ValidationErrorResource([
                'message' => 'Game not found',
                'errors' => [
                    'gameId' => ['The game with ID ' . $gameId . ' was not found']
                ]
            ]);
        }

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

        // Return GetGame200Resource (HTTP 200 hardcoded)
        $resource = new GetGame200Resource($game);
        // Note: No Location header for GET

        return $resource;
    }
}
