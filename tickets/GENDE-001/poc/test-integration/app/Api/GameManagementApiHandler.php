<?php

declare(strict_types=1);

namespace App\Api;

use App\Models\BadRequestError;
use App\Models\CreateGameRequest;
use App\Models\ForbiddenError;
use App\Models\Game;
use App\Models\GameListResponse;
use App\Models\GameStatus;
use App\Models\NotFoundError;
use App\Models\UnauthorizedError;
use App\Models\ValidationError;
use App\Http\Resources\CreateGame201Resource;
use App\Http\Resources\DeleteGame204Resource;
use App\Http\Resources\GetGame200Resource;
use App\Http\Resources\ListGames200Resource;

/**
 * GameManagementApiHandler
 *
 * Test implementation of GameManagementApiApi interface
 * Provides mock business logic for integration testing
 */
class GameManagementApiHandler implements GameManagementApiApi
{
    /**
     * Create a new game
     *
     * Returns a successful game creation response with mock data
     */
    public function createGame(
        CreateGameRequest $create_game_request
    ): CreateGame201Resource
    {
        // Mock game data
        $gameData = [
            'id' => 'test-game-' . uniqid(),
            'mode' => $create_game_request->mode,
            'status' => 'WAITING',
            'createdAt' => date('Y-m-d\TH:i:s\Z'),
            'updatedAt' => date('Y-m-d\TH:i:s\Z'),
        ];

        if ($create_game_request->opponentId !== null) {
            $gameData['opponentId'] = $create_game_request->opponentId;
        }

        if ($create_game_request->isPrivate !== null) {
            $gameData['isPrivate'] = $create_game_request->isPrivate;
        }

        $game = Game::fromArray($gameData);

        return new CreateGame201Resource($game, [
            'Location' => '/games/' . $gameData['id']
        ]);
    }

    /**
     * Delete a game
     *
     * Returns successful deletion response
     */
    public function deleteGame(
        string $game_id
    ): DeleteGame204Resource
    {
        // In a real implementation, would delete from database
        // For testing, just return success
        return new DeleteGame204Resource(null, []);
    }

    /**
     * Get game details
     *
     * Returns mock game data
     */
    public function getGame(
        string $game_id
    ): GetGame200Resource
    {
        // Mock game data
        $gameData = [
            'id' => $game_id,
            'mode' => 'PVP',
            'status' => 'IN_PROGRESS',
            'createdAt' => date('Y-m-d\TH:i:s\Z'),
            'updatedAt' => date('Y-m-d\TH:i:s\Z'),
        ];

        $game = Game::fromArray($gameData);

        return new GetGame200Resource($game, []);
    }

    /**
     * List all games
     *
     * Returns mock paginated game list
     */
    public function listGames(
        int $page,
        int $limit,
        GameStatus $status,
        string $player_id
    ): ListGames200Resource
    {
        // Mock game list data
        $games = [
            [
                'id' => 'game-1',
                'mode' => 'PVP',
                'status' => 'IN_PROGRESS',
                'createdAt' => date('Y-m-d\TH:i:s\Z'),
                'updatedAt' => date('Y-m-d\TH:i:s\Z'),
            ],
            [
                'id' => 'game-2',
                'mode' => 'PVC',
                'status' => 'COMPLETED',
                'createdAt' => date('Y-m-d\TH:i:s\Z'),
                'updatedAt' => date('Y-m-d\TH:i:s\Z'),
            ],
        ];

        $gameModels = array_map(fn($g) => Game::fromArray($g), $games);

        $response = GameListResponse::fromArray([
            'games' => $gameModels,
            'pagination' => [
                'page' => $page,
                'limit' => $limit,
                'total' => count($gameModels),
            ],
        ]);

        return new ListGames200Resource($response, []);
    }
}
