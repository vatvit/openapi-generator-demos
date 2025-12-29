<?php

declare(strict_types=1);

namespace App\Api;

use App\Models\Game;
use App\Models\MoveHistory;
use App\Models\MoveRequest;
use App\Models\SquareResponse;
use App\Http\Resources\GetBoard200Resource;
use App\Http\Resources\GetGame200Resource;
use App\Http\Resources\GetMoves200Resource;
use App\Http\Resources\GetSquare200Resource;
use App\Http\Resources\PutSquare200Resource;

/**
 * GameplayApiHandler
 *
 * Test implementation of GameplayApiApi interface
 * Provides mock business logic for integration testing
 */
class GameplayApiHandler implements GameplayApiApi
{
    /**
     * Get the game board
     */
    public function getBoard(
        string $game_id
    ): GetBoard200Resource
    {
        // Mock board data
        $boardData = [
            'board' => [
                ['X', 'O', 'X'],
                ['O', 'X', null],
                [null, null, 'O'],
            ],
            'winner' => null,
        ];

        return new GetBoard200Resource($boardData, []);
    }

    /**
     * Get game details
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
     * Get move history
     */
    public function getMoves(
        string $game_id
    ): GetMoves200Resource
    {
        // Mock move history
        $movesData = [
            'moves' => [
                [
                    'row' => 0,
                    'column' => 0,
                    'mark' => 'X',
                    'timestamp' => date('Y-m-d\TH:i:s\Z'),
                ],
                [
                    'row' => 0,
                    'column' => 1,
                    'mark' => 'O',
                    'timestamp' => date('Y-m-d\TH:i:s\Z'),
                ],
            ],
        ];

        $history = MoveHistory::fromArray($movesData);

        return new GetMoves200Resource($history, []);
    }

    /**
     * Get a single board square
     */
    public function getSquare(
        string $game_id,
        int $row,
        int $column
    ): GetSquare200Resource
    {
        // Mock square data
        $squareData = [
            'row' => $row,
            'column' => $column,
            'mark' => ($row + $column) % 2 === 0 ? 'X' : 'O',
        ];

        $square = SquareResponse::fromArray($squareData);

        return new GetSquare200Resource($square, []);
    }

    /**
     * Set a single board square
     */
    public function putSquare(
        string $game_id,
        int $row,
        int $column,
        MoveRequest $move_request
    ): PutSquare200Resource
    {
        // Mock updated board after move
        $boardData = [
            'board' => [
                ['X', 'O', 'X'],
                ['O', 'X', $move_request->mark ?? 'X'],
                [null, null, 'O'],
            ],
            'winner' => null,
        ];

        return new PutSquare200Resource($boardData, []);
    }
}
