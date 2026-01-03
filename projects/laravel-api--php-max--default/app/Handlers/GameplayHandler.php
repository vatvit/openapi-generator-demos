<?php

declare(strict_types=1);

namespace App\Handlers;

use TictactoeApi\Api\Handlers\GameplayApiHandlerInterface;
use TictactoeApi\Model\Game;
use TictactoeApi\Model\GameMode;
use TictactoeApi\Model\GameStatus;
use TictactoeApi\Model\Mark;
use TictactoeApi\Model\Move;
use TictactoeApi\Model\MoveHistory;
use TictactoeApi\Model\MoveRequest;
use TictactoeApi\Model\NotFoundError;
use TictactoeApi\Model\BadRequestError;
use TictactoeApi\Model\Error;
use TictactoeApi\Model\SquareResponse;
use TictactoeApi\Model\Status;
use TictactoeApi\Model\Winner;
use TictactoeApi\Api\Http\Resources\GetBoard200Resource;
use TictactoeApi\Api\Http\Resources\GetBoard404Resource;
use TictactoeApi\Api\Http\Resources\GetGame200Resource;
use TictactoeApi\Api\Http\Resources\GetGame404Resource;
use TictactoeApi\Api\Http\Resources\GetMoves200Resource;
use TictactoeApi\Api\Http\Resources\GetMoves404Resource;
use TictactoeApi\Api\Http\Resources\GetSquare200Resource;
use TictactoeApi\Api\Http\Resources\GetSquare400Resource;
use TictactoeApi\Api\Http\Resources\GetSquare404Resource;
use TictactoeApi\Api\Http\Resources\PutSquare200Resource;
use TictactoeApi\Api\Http\Resources\PutSquare400Resource;
use TictactoeApi\Api\Http\Resources\PutSquare404Resource;
use TictactoeApi\Api\Http\Resources\PutSquare409Resource;

/**
 * Gameplay Handler Implementation
 *
 * Implements the GameplayApiHandler interface with simple in-memory game logic.
 */
class GameplayHandler implements GameplayApiHandlerInterface
{
    /**
     * In-memory game storage
     * @var array<string, array{board: array<int, array<int, string>>, moves: array<int, mixed>}>
     */
    private static array $games = [];

    /**
     * Get the game board
     */
    public function getBoard(
        string $game_id
    ): GetBoard200Resource|GetBoard404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetBoard404Resource(new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            ));
        }

        $gameData = $this->getOrCreateGame($game_id);
        $winner = $this->checkWinner($gameData['board']);

        $status = new Status(
            winner: $winner,
            board: $gameData['board']
        );

        return new GetBoard200Resource($status);
    }

    /**
     * Get game details
     */
    public function getGame(
        string $game_id
    ): GetGame200Resource|GetGame404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetGame404Resource(new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            ));
        }

        $gameData = $this->getOrCreateGame($game_id);
        $winner = $this->checkWinner($gameData['board']);

        $gameStatus = $winner === Winner::EMPTY ? GameStatus::IN_PROGRESS : GameStatus::COMPLETED;

        $game = new Game(
            id: $game_id,
            status: $gameStatus,
            mode: GameMode::PVP,
            board: $gameData['board'],
            createdAt: new \DateTime()
        );

        return new GetGame200Resource($game);
    }

    /**
     * Get move history
     */
    public function getMoves(
        string $game_id
    ): GetMoves200Resource|GetMoves404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetMoves404Resource(new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            ));
        }

        $gameData = $this->getOrCreateGame($game_id);

        $moveHistory = new MoveHistory(
            gameId: $game_id,
            moves: $gameData['moves']
        );

        return new GetMoves200Resource($moveHistory);
    }

    /**
     * Get a single board square
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column
    ): GetSquare200Resource|GetSquare400Resource|GetSquare404Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new GetSquare404Resource(new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            ));
        }

        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            return new GetSquare400Resource(new BadRequestError(
                code: 'INVALID_COORDINATES',
                message: 'Row and column must be between 1 and 3'
            ));
        }

        $gameData = $this->getOrCreateGame($game_id);
        $markValue = $gameData['board'][$row - 1][$column - 1] ?? '.';
        $mark = Mark::tryFrom($markValue) ?? Mark::EMPTY;

        $squareResponse = new SquareResponse(
            row: $row,
            column: $column,
            mark: $mark
        );

        return new GetSquare200Resource($squareResponse);
    }

    /**
     * Set a single board square (make a move)
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        MoveRequest $move_request
    ): PutSquare200Resource|PutSquare400Resource|PutSquare404Resource|PutSquare409Resource {
        if (str_starts_with($game_id, 'notfound')) {
            return new PutSquare404Resource(new NotFoundError(
                code: 'GAME_NOT_FOUND',
                message: 'Game not found'
            ));
        }

        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            return new PutSquare400Resource(new BadRequestError(
                code: 'INVALID_COORDINATES',
                message: 'Row and column must be between 1 and 3'
            ));
        }

        $markValue = strtoupper($move_request->mark);
        if (!in_array($markValue, ['X', 'O'])) {
            return new PutSquare400Resource(new BadRequestError(
                code: 'INVALID_MARK',
                message: 'Mark must be X or O'
            ));
        }

        $gameData = $this->getOrCreateGame($game_id);

        // Check if game is already finished
        $currentWinner = $this->checkWinner($gameData['board']);
        if ($currentWinner !== Winner::EMPTY) {
            return new PutSquare409Resource(new Error(
                code: 'GAME_FINISHED',
                message: 'Game is already finished'
            ));
        }

        // Check if square is already occupied
        $currentMark = $gameData['board'][$row - 1][$column - 1] ?? '.';
        if ($currentMark !== '.') {
            return new PutSquare409Resource(new Error(
                code: 'SQUARE_OCCUPIED',
                message: 'Square is already occupied'
            ));
        }

        // Make the move
        $gameData['board'][$row - 1][$column - 1] = $markValue;

        // Record the move
        $moveNumber = count($gameData['moves']) + 1;
        $gameData['moves'][] = new Move(
            moveNumber: $moveNumber,
            playerId: $markValue === 'X' ? 'player_x' : 'player_o',
            mark: $markValue,
            row: $row,
            column: $column,
            timestamp: new \DateTime()
        );

        // Save game state
        self::$games[$game_id] = $gameData;

        // Check for winner after move
        $winner = $this->checkWinner($gameData['board']);

        $status = new Status(
            winner: $winner,
            board: $gameData['board']
        );

        return new PutSquare200Resource($status);
    }

    /**
     * Get or create a game state
     * @return array{board: array<int, array<int, string>>, moves: array<int, mixed>}
     */
    private function getOrCreateGame(string $game_id): array
    {
        if (!isset(self::$games[$game_id])) {
            self::$games[$game_id] = [
                'board' => [
                    ['.', '.', '.'],
                    ['.', '.', '.'],
                    ['.', '.', '.'],
                ],
                'moves' => [],
            ];
        }
        return self::$games[$game_id];
    }

    /**
     * Check for a winner
     * @param array<int, array<int, string>> $board
     */
    private function checkWinner(array $board): Winner
    {
        // Check rows
        for ($i = 0; $i < 3; $i++) {
            if ($board[$i][0] !== '.' && $board[$i][0] === $board[$i][1] && $board[$i][1] === $board[$i][2]) {
                return Winner::from($board[$i][0]);
            }
        }

        // Check columns
        for ($j = 0; $j < 3; $j++) {
            if ($board[0][$j] !== '.' && $board[0][$j] === $board[1][$j] && $board[1][$j] === $board[2][$j]) {
                return Winner::from($board[0][$j]);
            }
        }

        // Check diagonals
        if ($board[0][0] !== '.' && $board[0][0] === $board[1][1] && $board[1][1] === $board[2][2]) {
            return Winner::from($board[0][0]);
        }
        if ($board[0][2] !== '.' && $board[0][2] === $board[1][1] && $board[1][1] === $board[2][0]) {
            return Winner::from($board[0][2]);
        }

        return Winner::EMPTY;
    }

    /**
     * Reset all games (useful for testing)
     */
    public static function resetGames(): void
    {
        self::$games = [];
    }
}
