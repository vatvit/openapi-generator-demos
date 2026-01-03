<?php

declare(strict_types=1);

namespace App\Handler;

use TictactoeApi\Api\Handler\GameplayApiHandlerInterface;
use TictactoeApi\Api\Response\GetBoard200Response;
use TictactoeApi\Api\Response\GetBoard404Response;
use TictactoeApi\Api\Response\GetGame200Response;
use TictactoeApi\Api\Response\GetGame404Response;
use TictactoeApi\Api\Response\GetMoves200Response;
use TictactoeApi\Api\Response\GetMoves404Response;
use TictactoeApi\Api\Response\GetSquare200Response;
use TictactoeApi\Api\Response\GetSquare400Response;
use TictactoeApi\Api\Response\GetSquare404Response;
use TictactoeApi\Api\Response\PutSquare200Response;
use TictactoeApi\Api\Response\PutSquare400Response;
use TictactoeApi\Api\Response\PutSquare404Response;
use TictactoeApi\Api\Response\PutSquare409Response;
use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\Mark;
use TictactoeApi\Model\Move;
use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Model\Status;
use TictactoeApi\Model\Winner;

/**
 * Handler for Gameplay API operations.
 *
 * Mock implementation with in-memory game state for testing purposes.
 */
class GameplayHandler implements GameplayApiHandlerInterface
{
    /** @var array<string, array<array<Mark|null>>> */
    private static array $games = [];

    /** @var array<string, array<Move>> */
    private static array $moves = [];

    /** @var array<string, Winner> */
    private static array $winners = [];

    public static function resetGames(): void
    {
        self::$games = [];
        self::$moves = [];
        self::$winners = [];
    }

    private function getOrCreateGame(string $gameId): array
    {
        if (!isset(self::$games[$gameId])) {
            self::$games[$gameId] = [
                [null, null, null],
                [null, null, null],
                [null, null, null],
            ];
            self::$moves[$gameId] = [];
            self::$winners[$gameId] = Winner::EMPTY;
        }
        return self::$games[$gameId];
    }

    private function checkWinner(array $board): Winner
    {
        // Check rows
        for ($i = 0; $i < 3; $i++) {
            if ($board[$i][0] !== null && $board[$i][0] === $board[$i][1] && $board[$i][1] === $board[$i][2]) {
                return $board[$i][0] === Mark::X ? Winner::X : Winner::O;
            }
        }

        // Check columns
        for ($i = 0; $i < 3; $i++) {
            if ($board[0][$i] !== null && $board[0][$i] === $board[1][$i] && $board[1][$i] === $board[2][$i]) {
                return $board[0][$i] === Mark::X ? Winner::X : Winner::O;
            }
        }

        // Check diagonals
        if ($board[0][0] !== null && $board[0][0] === $board[1][1] && $board[1][1] === $board[2][2]) {
            return $board[0][0] === Mark::X ? Winner::X : Winner::O;
        }
        if ($board[0][2] !== null && $board[0][2] === $board[1][1] && $board[1][1] === $board[2][0]) {
            return $board[0][2] === Mark::X ? Winner::X : Winner::O;
        }

        return Winner::EMPTY;
    }

    public function getBoard(
        string $game_id,
    ): GetBoard200Response|GetBoard404Response {
        if (str_starts_with($game_id, 'notfound')) {
            $error = new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            );
            return GetBoard404Response::create($error);
        }

        $board = $this->getOrCreateGame($game_id);
        $winner = self::$winners[$game_id] ?? Winner::EMPTY;

        $status = new Status(
            winner: $winner,
            board: $board
        );

        return GetBoard200Response::create($status);
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

        $board = $this->getOrCreateGame($game_id);

        $game = new Game(
            id: $game_id,
            status: GameStatus::IN_PROGRESS,
            mode: GameMode::PVP,
            board: $board,
            createdAt: new \DateTime()
        );

        return GetGame200Response::create($game);
    }

    public function getMoves(
        string $game_id,
    ): GetMoves200Response|GetMoves404Response {
        if (str_starts_with($game_id, 'notfound')) {
            $error = new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            );
            return GetMoves404Response::create($error);
        }

        $this->getOrCreateGame($game_id);
        $moves = self::$moves[$game_id] ?? [];

        $moveHistory = new MoveHistory(
            gameId: $game_id,
            moves: $moves
        );

        return GetMoves200Response::create($moveHistory);
    }

    public function getSquare(
        string $game_id,
        int $row,
        int $column,
    ): GetSquare200Response|GetSquare400Response|GetSquare404Response {
        if (str_starts_with($game_id, 'notfound')) {
            $error = new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            );
            return GetSquare404Response::create($error);
        }

        // Validate coordinates (1-3 range)
        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            $error = new BadRequestError(
                code: 'INVALID_COORDINATES',
                message: 'Row and column must be between 1 and 3'
            );
            return GetSquare400Response::create($error);
        }

        $board = $this->getOrCreateGame($game_id);
        $mark = $board[$row - 1][$column - 1] ?? Mark::EMPTY;

        $square = new SquareResponse(
            row: $row,
            column: $column,
            mark: $mark
        );

        return GetSquare200Response::create($square);
    }

    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        MoveRequest $move_request
    ): PutSquare200Response|PutSquare400Response|PutSquare404Response|PutSquare409Response {
        if (str_starts_with($game_id, 'notfound')) {
            $error = new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            );
            return PutSquare404Response::create($error);
        }

        // Validate coordinates (1-3 range)
        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            $error = new BadRequestError(
                code: 'INVALID_COORDINATES',
                message: 'Row and column must be between 1 and 3'
            );
            return PutSquare400Response::create($error);
        }

        // Validate and convert mark string to enum
        $markString = $move_request->mark;
        if (!in_array($markString, ['X', 'O'], true)) {
            $error = new BadRequestError(
                code: 'INVALID_MARK',
                message: 'Mark must be X or O'
            );
            return PutSquare400Response::create($error);
        }
        $markValue = Mark::from($markString);

        $board = $this->getOrCreateGame($game_id);

        // Check if game is already finished
        if ((self::$winners[$game_id] ?? Winner::EMPTY) !== Winner::EMPTY) {
            $error = new Error(
                code: 'GAME_FINISHED',
                message: 'Game is already finished'
            );
            return PutSquare409Response::create($error);
        }

        // Check if square is already occupied
        if ($board[$row - 1][$column - 1] !== null) {
            $error = new Error(
                code: 'SQUARE_OCCUPIED',
                message: 'Square is already occupied'
            );
            return PutSquare409Response::create($error);
        }

        // Place the mark
        $board[$row - 1][$column - 1] = $markValue;
        self::$games[$game_id] = $board;

        // Record the move
        $moveNumber = count(self::$moves[$game_id] ?? []) + 1;
        self::$moves[$game_id][] = new Move(
            moveNumber: $moveNumber,
            playerId: 'player-' . $markValue->value,
            mark: $markValue->value,
            row: $row,
            column: $column,
            timestamp: new \DateTime()
        );

        // Check for winner
        $winner = $this->checkWinner($board);
        self::$winners[$game_id] = $winner;

        $status = new Status(
            winner: $winner,
            board: $board
        );

        return PutSquare200Response::create($status);
    }
}
