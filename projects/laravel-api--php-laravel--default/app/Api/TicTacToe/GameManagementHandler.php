<?php

declare(strict_types=1);

namespace App\Api\TicTacToe;

use TicTacToeApi\Api\GameManagementApiInterface;
use TicTacToeApi\Model\Game;
use TicTacToeApi\Model\GameListResponse;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\NoContent204;
use TicTacToeApi\Model\NotFoundError;

/**
 * Stub handler for GameManagement API.
 *
 * Demonstrates OOTB php-laravel integration pattern.
 */
class GameManagementHandler implements GameManagementApiInterface
{
    public function createGame(CreateGameRequest $createGameRequest): Game
    {
        // Stub implementation - return mock data
        return new Game(
            id: 'game-' . uniqid(),
            status: GameStatus::IN_PROGRESS,
        );
    }

    public function deleteGame(string $gameId): NoContent204
    {
        // Stub implementation
        return new NoContent204();
    }

    public function getGame(string $gameId): Game|NotFoundError
    {
        // Stub implementation
        return new Game(
            id: $gameId,
            status: GameStatus::IN_PROGRESS,
        );
    }

    public function listGames(
        ?int $page,
        ?int $limit,
        ?GameStatus $status,
        ?string $playerId
    ): GameListResponse {
        // Stub implementation
        return new GameListResponse(
            games: [],
        );
    }
}
