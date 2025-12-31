<?php

declare(strict_types=1);

namespace App\Handlers;

use TictactoeApi\Api\Handlers\GameManagementApiHandler;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Api\Http\Resources\CreateGame201Resource;
use TictactoeApi\Api\Http\Resources\CreateGame400Resource;
use TictactoeApi\Api\Http\Resources\CreateGame401Resource;
use TictactoeApi\Api\Http\Resources\CreateGame422Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame204Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame403Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame404Resource;
use TictactoeApi\Api\Http\Resources\GetGame200Resource;
use TictactoeApi\Api\Http\Resources\GetGame404Resource;
use TictactoeApi\Api\Http\Resources\ListGames200Resource;
use TictactoeApi\Api\Http\Resources\ListGames400Resource;
use TictactoeApi\Api\Http\Resources\ListGames401Resource;

/**
 * Demo Handler Implementation
 *
 * This demonstrates how to implement the generated Handler interface.
 * In a real application, this would contain actual business logic:
 * - Database operations
 * - External service calls
 * - Business rule validation
 *
 * KEY CONCEPTS:
 * 1. Implement the generated interface (type safety)
 * 2. Return appropriate Resource for each scenario
 * 3. Union return types enforce valid responses only
 */
class DemoGameManagementHandler implements GameManagementApiHandler
{
    /**
     * Create a new game
     *
     * @param CreateGameRequest $create_game_request Validated request DTO
     * @return CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource
     */
    public function createGame(
        CreateGameRequest $create_game_request
    ): CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource {
        // Create a new game using the DTO data
        $game = new Game(
            id: 'game_' . uniqid(),
            status: GameStatus::PENDING,
            mode: $create_game_request->mode,
            board: [
                [null, null, null],
                [null, null, null],
                [null, null, null],
            ],
            createdAt: new \DateTime()
        );

        // Return 201 Created with the new game
        return new CreateGame201Resource($game);
    }

    /**
     * Get game details
     *
     * @param string $game_id Unique game identifier
     * @return GetGame200Resource|GetGame404Resource
     */
    public function getGame(
        string $game_id
    ): GetGame200Resource|GetGame404Resource {
        // Demo: return 404 for IDs starting with "notfound"
        if (str_starts_with($game_id, 'notfound')) {
            return new GetGame404Resource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND'
            ]);
        }

        // Demo: create a mock game
        $game = new Game(
            id: $game_id,
            status: GameStatus::IN_PROGRESS,
            mode: GameMode::PVP,
            board: [
                ['X', 'O', null],
                [null, 'X', null],
                [null, null, 'O'],
            ],
            createdAt: new \DateTime()
        );

        return new GetGame200Resource($game);
    }

    /**
     * Delete a game
     *
     * @param string $game_id Unique game identifier
     * @return DeleteGame204Resource|DeleteGame403Resource|DeleteGame404Resource
     */
    public function deleteGame(
        string $game_id
    ): DeleteGame204Resource|DeleteGame403Resource|DeleteGame404Resource {
        // Demo: return 404 for IDs starting with "notfound"
        if (str_starts_with($game_id, 'notfound')) {
            return new DeleteGame404Resource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND'
            ]);
        }

        // Demo: return 403 for IDs starting with "forbidden"
        if (str_starts_with($game_id, 'forbidden')) {
            return new DeleteGame403Resource([
                'message' => 'You do not have permission to delete this game',
                'code' => 'FORBIDDEN'
            ]);
        }

        // Success - return 204 No Content
        return new DeleteGame204Resource(null);
    }

    /**
     * List all games
     *
     * @param int $page Page number
     * @param int $limit Items per page
     * @param GameStatus $status Filter by status
     * @param string $player_id Filter by player
     * @return ListGames200Resource|ListGames400Resource|ListGames401Resource
     */
    public function listGames(
        int $page,
        int $limit,
        GameStatus $status,
        string $player_id
    ): ListGames200Resource|ListGames400Resource|ListGames401Resource {
        // Demo: return mock game list
        $games = [
            new Game(
                id: 'game_001',
                status: GameStatus::IN_PROGRESS,
                mode: GameMode::PVP,
                board: [[null, null, null], [null, null, null], [null, null, null]],
                createdAt: new \DateTime()
            ),
            new Game(
                id: 'game_002',
                status: GameStatus::COMPLETED,
                mode: GameMode::AI_EASY,
                board: [['X', 'O', 'X'], ['O', 'X', 'O'], ['X', null, null]],
                createdAt: new \DateTime()
            ),
        ];

        // ListGames200Resource is a ResourceCollection - pass array of games
        $resource = new ListGames200Resource($games);
        $resource->xTotalCount = count($games);
        $resource->xPageNumber = $page;

        return $resource;
    }
}
