<?php

declare(strict_types=1);

namespace App\Api\TicTacToe;

use TicTacToeApi\Api\GameplayApiInterface;
use TicTacToeApi\Model\Game;
use TicTacToeApi\Model\GameStatus;
use TicTacToeApi\Model\MoveHistory;
use TicTacToeApi\Model\MoveRequest;
use TicTacToeApi\Model\NotFoundError;
use TicTacToeApi\Model\SquareResponse;
use TicTacToeApi\Model\Status;

/**
 * Stub handler for Gameplay API.
 */
class GameplayHandler implements GameplayApiInterface
{
    public function getBoard(string $gameId): Status
    {
        return new Status(
            board: [['X', null, 'O'], [null, 'X', null], [null, null, null]],
        );
    }

    public function getGame(string $gameId): Game|NotFoundError
    {
        return new Game(
            id: $gameId,
            status: GameStatus::IN_PROGRESS,
        );
    }

    public function getMoves(string $gameId): MoveHistory
    {
        return new MoveHistory(
            moves: [],
        );
    }

    public function getSquare(string $gameId, int $row, int $column): SquareResponse
    {
        return new SquareResponse(
            mark: 'X',
        );
    }

    public function putSquare(
        string $gameId,
        int $row,
        int $column,
        MoveRequest $moveRequest
    ): Status {
        return new Status(
            board: [['X', null, 'O'], [null, 'X', null], [null, null, null]],
        );
    }
}
