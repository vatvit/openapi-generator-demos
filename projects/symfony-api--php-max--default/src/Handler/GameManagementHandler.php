<?php

declare(strict_types=1);

namespace App\Handler;

use TictactoeApi\Api\Handler\GameManagementApiHandlerInterface;
use TictactoeApi\Api\Response\CreateGame201Response;
use TictactoeApi\Api\Response\CreateGame400Response;
use TictactoeApi\Api\Response\CreateGame401Response;
use TictactoeApi\Api\Response\CreateGame422Response;
use TictactoeApi\Api\Response\DeleteGame204Response;
use TictactoeApi\Api\Response\DeleteGame403Response;
use TictactoeApi\Api\Response\DeleteGame404Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\ListGames200Response;
use TictactoeApi\Api\Response\ListGames400Response;
use TictactoeApi\Api\Response\ListGames401Response;
use TictactoeApi\Model\CreateGameRequest;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameListResponse;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\Pagination;

/**
 * Handler for Game Management API operations.
 *
 * This is a sample implementation demonstrating how to implement
 * the generated interface. In a real application, this would
 * interact with a database or other persistence layer.
 */
class GameManagementHandler implements GameManagementApiHandlerInterface
{
    public function createGame(
        CreateGameRequest $create_game_request
    ): CreateGame201Response|CreateGame400Response|CreateGame401Response|CreateGame422Response {
        // Create a sample game with empty board
        $emptyBoard = [
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ];
        $game = new Game(
            id: 'game-' . uniqid(),
            status: GameStatus::IN_PROGRESS,
            mode: $create_game_request->mode ?? GameMode::PVP,
            board: $emptyBoard,
            createdAt: new \DateTime()
        );

        return CreateGame201Response::create($game);
    }

    public function deleteGame(
        string $game_id,
    ): DeleteGame204Response|DeleteGame403Response|DeleteGame404Response {
        // In a real app, delete from database
        if (str_starts_with($game_id, 'notfound')) {
            $error = new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            );
            return DeleteGame404Response::create($error);
        }

        return DeleteGame204Response::create();
    }

    public function getGame(
        string $game_id,
    ): GetGame200Response|GetGame404Response {
        if (str_starts_with($game_id, 'notfound')) {
            $error = new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            );
            return GetGame404Response::create($error);
        }

        $board = [
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ];
        $game = new Game(
            id: $game_id,
            status: GameStatus::IN_PROGRESS,
            mode: GameMode::PVP,
            board: $board,
            createdAt: new \DateTime()
        );

        return GetGame200Response::create($game);
    }

    public function listGames(
        int|null $page = null,
        int|null $limit = null,
        GameStatus|null $status = null,
        string|null $player_id = null,
    ): ListGames200Response|ListGames400Response|ListGames401Response {
        $board = [
            [null, null, null],
            [null, null, null],
            [null, null, null],
        ];
        $games = [
            new Game(
                id: 'game-1',
                status: $status ?? GameStatus::IN_PROGRESS,
                mode: GameMode::PVP,
                board: $board,
                createdAt: new \DateTime()
            ),
        ];

        $pagination = new Pagination(
            page: $page ?? 1,
            limit: $limit ?? 10,
            total: 1
        );

        $response = new GameListResponse(
            games: $games,
            pagination: $pagination
        );

        return ListGames200Response::create($response);
    }
}
