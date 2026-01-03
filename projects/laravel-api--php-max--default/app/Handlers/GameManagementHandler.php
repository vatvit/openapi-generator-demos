<?php

declare(strict_types=1);

namespace App\Handlers;

use TictactoeApi\Api\Handlers\GameManagementApiHandlerInterface;
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
 * Game Management Handler Implementation
 *
 * Implements the GameManagementApiHandler interface for CRUD operations on games.
 */
class GameManagementHandler implements GameManagementApiHandlerInterface
{
    /**
     * Create a new game
     */
    public function createGame(
        CreateGameRequest $create_game_request
    ): CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource {
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

        return new CreateGame201Resource($game);
    }

    /**
     * Get game details
     */
    public function getGame(
        string $game_id
    ): GetGame200Resource|GetGame404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetGame404Resource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND'
            ]);
        }

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
     */
    public function deleteGame(
        string $game_id
    ): DeleteGame204Resource|DeleteGame403Resource|DeleteGame404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new DeleteGame404Resource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND'
            ]);
        }

        if (str_starts_with($game_id, 'forbidden')) {
            return new DeleteGame403Resource([
                'message' => 'You do not have permission to delete this game',
                'code' => 'FORBIDDEN'
            ]);
        }

        return new DeleteGame204Resource(null);
    }

    /**
     * List all games
     */
    public function listGames(
        ?int $page = null,
        ?int $limit = null,
        ?GameStatus $status = null,
        ?string $player_id = null
    ): ListGames200Resource|ListGames400Resource|ListGames401Resource {
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

        $resource = new ListGames200Resource($games);
        $resource->xTotalCount = (string) count($games);
        $resource->xPageNumber = $page !== null ? (string) $page : null;

        return $resource;
    }
}
