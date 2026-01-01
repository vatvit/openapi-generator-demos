<?php

declare(strict_types=1);

namespace App\Handler\TicTacToe;

use TicTacToeApi\Api\GameManagementApiInterface;
use TicTacToeApi\Model\CreateGameRequest;
use TicTacToeApi\Model\Game;
use TicTacToeApi\Model\GameListResponse;
use TicTacToeApi\Model\GameMode;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\NotFoundError;

/**
 * Handler for Game Management API operations.
 *
 * This is a sample implementation demonstrating how to implement
 * the generated interface. In a real application, this would
 * interact with a database or other persistence layer.
 */
class GameManagementHandler implements GameManagementApiInterface
{
    private ?string $bearerToken = null;

    public function setbearerHttpAuthentication(?string $value): void
    {
        $this->bearerToken = $value;
    }

    public function createGame(
        CreateGameRequest $createGameRequest,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null {
        // Create a sample game
        $game = new Game([
            'id' => 'game-' . uniqid(),
            'status' => GameStatus::IN_PROGRESS,
            'mode' => GameMode::PVP,
            'createdAt' => new \DateTime(),
        ]);

        $responseCode = 201;
        return $game;
    }

    public function deleteGame(
        string $gameId,
        int &$responseCode,
        array &$responseHeaders
    ): void {
        // In a real app, delete from database
        $responseCode = 204;
    }

    public function getGame(
        string $gameId,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null {
        // Return a sample game
        if ($gameId === 'not-found') {
            $responseCode = 404;
            return new NotFoundError([
                'code' => 'GAME_NOT_FOUND',
                'message' => 'Game not found',
            ]);
        }

        $game = new Game([
            'id' => $gameId,
            'status' => GameStatus::IN_PROGRESS,
            'mode' => GameMode::PVP,
            'createdAt' => new \DateTime(),
        ]);

        $responseCode = 200;
        return $game;
    }

    public function listGames(
        int $page,
        int $limit,
        ?\TicTacToeApi\Model\TicTacToeApi\Model\GameStatus $status,
        ?string $playerId,
        int &$responseCode,
        array &$responseHeaders
    ): array|object|null {
        // Return sample game list
        $games = [
            new Game([
                'id' => 'game-1',
                'status' => GameStatus::IN_PROGRESS,
                'mode' => GameMode::PVP,
                'createdAt' => new \DateTime(),
            ]),
        ];

        $response = new GameListResponse([
            'games' => $games,
            'total' => 1,
            'page' => $page,
            'limit' => $limit,
        ]);

        $responseCode = 200;
        return $response;
    }
}
