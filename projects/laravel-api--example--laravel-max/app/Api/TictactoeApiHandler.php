<?php

declare(strict_types=1);

namespace App\Api;

// Per-operation Handler Interfaces
use TictactoeApi\Api\Handlers\CreateGameApiHandlerInterface;
use TictactoeApi\Api\Handlers\DeleteGameApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetBoardApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetGameApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetLeaderboardApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetMovesApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetPlayerStatsApiHandlerInterface;
use TictactoeApi\Api\Handlers\GetSquareApiHandlerInterface;
use TictactoeApi\Api\Handlers\ListGamesApiHandlerInterface;
use TictactoeApi\Api\Handlers\PutSquareApiHandlerInterface;

use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\Pagination;
use TictactoeApi\Model\Status;
use TictactoeApi\Model\Winner;
use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Model\Mark;
use TictactoeApi\Model\Leaderboard;
use TictactoeApi\Model\PlayerStats;

use TictactoeApi\Api\Http\Resources\CreateGame201Resource;
use TictactoeApi\Api\Http\Resources\CreateGame400Resource;
use TictactoeApi\Api\Http\Resources\CreateGame401Resource;
use TictactoeApi\Api\Http\Resources\CreateGame422Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame204Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame403Resource;
use TictactoeApi\Api\Http\Resources\DeleteGame404Resource;
use TictactoeApi\Api\Http\Resources\GetBoard200Resource;
use TictactoeApi\Api\Http\Resources\GetBoard404Resource;
use TictactoeApi\Api\Http\Resources\GetGame200Resource;
use TictactoeApi\Api\Http\Resources\GetGame404Resource;
use TictactoeApi\Api\Http\Resources\GetLeaderboard200Resource;
use TictactoeApi\Api\Http\Resources\GetMoves200Resource;
use TictactoeApi\Api\Http\Resources\GetMoves404Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats200Resource;
use TictactoeApi\Api\Http\Resources\GetPlayerStats404Resource;
use TictactoeApi\Api\Http\Resources\GetSquare200Resource;
use TictactoeApi\Api\Http\Resources\GetSquare400Resource;
use TictactoeApi\Api\Http\Resources\GetSquare404Resource;
use TictactoeApi\Api\Http\Resources\ListGames200Resource;
use TictactoeApi\Api\Http\Resources\ListGames400Resource;
use TictactoeApi\Api\Http\Resources\ListGames401Resource;
use TictactoeApi\Api\Http\Resources\PutSquare200Resource;
use TictactoeApi\Api\Http\Resources\PutSquare400Resource;
use TictactoeApi\Api\Http\Resources\PutSquare404Resource;
use TictactoeApi\Api\Http\Resources\PutSquare409Resource;

/**
 * TictactoeApiHandler
 *
 * Unified handler implementing all TicTacToe API per-operation interfaces.
 * This is a demo implementation for testing purposes.
 */
class TictactoeApiHandler implements
    CreateGameApiHandlerInterface,
    DeleteGameApiHandlerInterface,
    GetBoardApiHandlerInterface,
    GetGameApiHandlerInterface,
    GetLeaderboardApiHandlerInterface,
    GetMovesApiHandlerInterface,
    GetPlayerStatsApiHandlerInterface,
    GetSquareApiHandlerInterface,
    ListGamesApiHandlerInterface,
    PutSquareApiHandlerInterface
{
    // =========================================================================
    // Game Management
    // =========================================================================

    public function createGame(
        CreateGameRequest $create_game_request
    ): CreateGame201Resource|CreateGame400Resource|CreateGame401Resource|CreateGame422Resource {
        $game = new Game(
            id: 'game_' . uniqid(),
            status: GameStatus::PENDING,
            mode: $create_game_request->mode ?? GameMode::PVP,
            board: [['.', '.', '.'], ['.', '.', '.'], ['.', '.', '.']],
            createdAt: new \DateTime(),
        );

        $resource = new CreateGame201Resource($game);
        $resource->location = '/games/' . $game->id;

        return $resource;
    }

    public function deleteGame(
        string $game_id
    ): DeleteGame204Resource|DeleteGame403Resource|DeleteGame404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new DeleteGame404Resource(null);
        }

        if (str_starts_with($game_id, 'forbidden')) {
            return new DeleteGame403Resource(null);
        }

        return new DeleteGame204Resource(null);
    }

    public function getGame(
        string $game_id
    ): GetGame200Resource|GetGame404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetGame404Resource(null);
        }

        $game = new Game(
            id: $game_id,
            status: GameStatus::IN_PROGRESS,
            mode: GameMode::PVP,
            board: [['X', '.', '.'], ['.', 'O', '.'], ['.', '.', '.']],
            createdAt: new \DateTime(),
        );

        return new GetGame200Resource($game);
    }

    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        GameStatus|null $status = null,
        string|null $player_id = null
    ): ListGames200Resource|ListGames400Resource|ListGames401Resource {
        $games = [
            new Game(
                id: 'game_1',
                status: GameStatus::IN_PROGRESS,
                mode: GameMode::PVP,
                board: [['.', '.', '.'], ['.', '.', '.'], ['.', '.', '.']],
                createdAt: new \DateTime(),
            ),
        ];

        $pagination = new Pagination(
            page: $page ?? 1,
            limit: $limit ?? 20,
            total: 1,
        );

        $response = new GameListResponse(
            games: $games,
            pagination: $pagination,
        );

        $resource = new ListGames200Resource($response);
        $resource->xTotalCount = '1';

        return $resource;
    }

    // =========================================================================
    // Gameplay
    // =========================================================================

    public function getBoard(
        string $game_id
    ): GetBoard200Resource|GetBoard404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetBoard404Resource(null);
        }

        $status = new Status(
            winner: Winner::EMPTY,
            board: [['X', '.', '.'], ['.', 'O', '.'], ['.', '.', '.']],
        );

        return new GetBoard200Resource($status);
    }

    public function getMoves(
        string $game_id
    ): GetMoves200Resource|GetMoves404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetMoves404Resource(null);
        }

        $moveHistory = new MoveHistory(
            gameId: $game_id,
            moves: [],
        );

        return new GetMoves200Resource($moveHistory);
    }

    public function getSquare(
        string $game_id,
        int $row,
        int $column
    ): GetSquare200Resource|GetSquare400Resource|GetSquare404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetSquare404Resource(null);
        }

        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            return new GetSquare400Resource(null);
        }

        $square = new SquareResponse(
            row: $row,
            column: $column,
            mark: Mark::EMPTY,
        );

        return new GetSquare200Resource($square);
    }

    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        MoveRequest $move_request
    ): PutSquare200Resource|PutSquare400Resource|PutSquare404Resource|PutSquare409Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new PutSquare404Resource(null);
        }

        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            return new PutSquare400Resource(null);
        }

        if (str_starts_with($game_id, 'occupied')) {
            return new PutSquare409Resource(null);
        }

        if (str_starts_with($game_id, 'finished')) {
            return new PutSquare409Resource(null);
        }

        $status = new Status(
            winner: Winner::EMPTY,
            board: [['X', '.', '.'], ['.', 'O', '.'], ['.', '.', '.']],
        );

        return new PutSquare200Resource($status);
    }

    // =========================================================================
    // Statistics
    // =========================================================================

    public function getLeaderboard(
        string|null $timeframe = null,
        int|null $limit = null
    ): GetLeaderboard200Resource {
        $leaderboard = new Leaderboard(
            timeframe: $timeframe ?? 'all-time',
            entries: [],
            generatedAt: new \DateTime(),
        );

        return new GetLeaderboard200Resource($leaderboard);
    }

    public function getPlayerStats(
        string $player_id
    ): GetPlayerStats200Resource|GetPlayerStats404Resource {
        if (str_starts_with($player_id, 'notfound')) {
            return new GetPlayerStats404Resource(null);
        }

        $stats = new PlayerStats(
            playerId: $player_id,
            gamesPlayed: 10,
            wins: 5,
            losses: 3,
            draws: 2,
            winRate: 0.5,
        );

        return new GetPlayerStats200Resource($stats);
    }
}
