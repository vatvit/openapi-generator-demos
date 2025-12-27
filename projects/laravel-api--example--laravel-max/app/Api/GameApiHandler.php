<?php

declare(strict_types=1);

namespace App\Api;

use LaravelMaxApi\Api\GameApi;
use LaravelMaxApi\Models\CreateGameRequestDto;
use LaravelMaxApi\Models\GameListQueryParams;
use LaravelMaxApi\Models\MoveRequestDto;
use LaravelMaxApi\Models\Game;
use LaravelMaxApi\Models\Board;
use LaravelMaxApi\Http\Resources\CreateGame201Resource;
use LaravelMaxApi\Http\Resources\GetGame200Resource;
use LaravelMaxApi\Http\Resources\ListGames200Resource;
use LaravelMaxApi\Http\Resources\DeleteGame204Resource;
use LaravelMaxApi\Http\Resources\GetBoard200Resource;
use LaravelMaxApi\Http\Resources\PutSquare200Resource;
use LaravelMaxApi\Http\Resources\ValidationErrorResource;
use LaravelMaxApi\Http\Resources\UnauthorizedErrorResource;
use LaravelMaxApi\Http\Resources\ForbiddenErrorResource;
use LaravelMaxApi\Http\Resources\NotFoundErrorResource;
use LaravelMaxApi\Http\Resources\ConflictErrorResource;

/**
 * GameApiHandler
 *
 * APPLICATION-LEVEL implementation of GameApi interface
 * This class is NOT part of the generated library - it's your business logic
 *
 * SEPARATION OF CONCERNS:
 * - Generated Library (laravel-max): Provides interface, controllers, validation, resources
 * - Application (this file): Implements the interface with actual business logic
 *
 * YOUR RESPONSIBILITIES:
 * - Implement all methods from GameApi interface
 * - Database operations (create, read, update, delete)
 * - Business rule validation
 * - External service calls
 * - Return appropriate Resource types for different scenarios
 */
class GameApiHandler implements GameApi
{
    /**
     * Create a new game
     *
     * @param CreateGameRequestDto $request Typed, validated request data
     * @return CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
     */
    public function createGame(CreateGameRequestDto $request): CreateGame201Resource|ValidationErrorResource|UnauthorizedErrorResource
    {
        // Business logic: Create game
        // (In real app: save to database, validate players exist, etc.)
        $game = new Game(
            id: 'game_' . uniqid(),
            status: 'waiting',
            mode: $request->mode,
            playerXId: $request->playerXId,
            playerOId: $request->playerOId,
            currentTurn: 'X',
            winner: null,
            createdAt: new \DateTime(),
            updatedAt: new \DateTime(),
        );

        // Return CreateGame201Resource with Location header
        $resource = new CreateGame201Resource($game);
        $resource->location = route('api.getGame', ['gameId' => $game->id]); // REQUIRED for 201

        return $resource;
    }

    /**
     * Get game details
     *
     * @param string $gameId
     * @return GetGame200Resource|ValidationErrorResource|NotFoundErrorResource
     */
    public function getGame(string $gameId): GetGame200Resource|ValidationErrorResource|NotFoundErrorResource
    {
        // Business logic: Fetch game from database
        // (In real app: query database, handle not found, etc.)

        // Example: Validate gameId format
        if (empty($gameId) || strlen($gameId) < 3) {
            return new ValidationErrorResource([
                'message' => 'Invalid game ID',
                'errors' => [
                    'gameId' => ['The game ID must be at least 3 characters']
                ]
            ]);
        }

        // Example: Game not found scenario (404)
        if (str_starts_with($gameId, 'notfound-')) {
            return new NotFoundErrorResource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND',
            ]);
        }

        // Example: Mock game data
        $game = new Game(
            id: $gameId,
            status: 'in-progress',
            mode: 'two-player',
            playerXId: 'player1',
            playerOId: 'player2',
            currentTurn: 'O',
            winner: null,
            createdAt: new \DateTime('2025-01-01'),
            updatedAt: new \DateTime(),
        );

        // Return GetGame200Resource (HTTP 200 hardcoded)
        $resource = new GetGame200Resource($game);
        // Note: No Location header for GET

        return $resource;
    }

    /**
     * List all games
     *
     * @param GameListQueryParams $query
     * @return ListGames200Resource|ValidationErrorResource|UnauthorizedErrorResource
     */
    public function listGames(GameListQueryParams $query): ListGames200Resource|ValidationErrorResource|UnauthorizedErrorResource
    {
        // Business logic: Query database with pagination and filters
        // (In real app: build database query with filters, pagination, etc.)

        // Example: Validate pagination parameters
        if ($query->page < 1) {
            return new ValidationErrorResource([
                'message' => 'Invalid pagination parameters',
                'errors' => [
                    'page' => ['Page number must be at least 1']
                ]
            ]);
        }

        if ($query->limit < 1 || $query->limit > 100) {
            return new ValidationErrorResource([
                'message' => 'Invalid pagination parameters',
                'errors' => [
                    'limit' => ['Limit must be between 1 and 100']
                ]
            ]);
        }

        // Example: Mock game list
        $games = collect([
            new Game(
                id: 'game_1',
                status: 'in-progress',
                mode: 'two-player',
                playerXId: 'player1',
                playerOId: 'player2',
                currentTurn: 'X',
                winner: null,
                createdAt: new \DateTime('2025-01-01'),
                updatedAt: new \DateTime(),
            ),
            new Game(
                id: 'game_2',
                status: 'completed',
                mode: 'single-player',
                playerXId: 'player1',
                playerOId: null,
                currentTurn: 'O',
                winner: 'X',
                createdAt: new \DateTime('2025-01-02'),
                updatedAt: new \DateTime(),
            ),
        ]);

        // Apply filters (example)
        if ($query->status) {
            $games = $games->filter(fn($g) => $g->status === $query->status);
        }

        if ($query->playerXId) {
            $games = $games->filter(fn($g) => $g->playerXId === $query->playerXId);
        }

        // Return ListGames200Resource with pagination headers
        $resource = new ListGames200Resource($games);
        $resource->xTotalCount = 42; // REQUIRED - total across all pages
        $resource->xPageNumber = $query->page; // OPTIONAL
        $resource->xPageSize = $query->limit; // OPTIONAL

        return $resource;
    }

    /**
     * Delete a game
     *
     * @param string $gameId
     * @return DeleteGame204Resource|ForbiddenErrorResource|NotFoundErrorResource
     */
    public function deleteGame(string $gameId): DeleteGame204Resource|ForbiddenErrorResource|NotFoundErrorResource
    {
        // Business logic: Check permissions and delete game
        // (In real app: check user owns game, delete from database, etc.)

        // Example: Game not found
        if (str_starts_with($gameId, 'notfound-')) {
            return new NotFoundErrorResource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND',
            ]);
        }

        // Example: Permission check - user doesn't own this game
        if (str_starts_with($gameId, 'forbidden-')) {
            return new ForbiddenErrorResource([
                'message' => 'You do not have permission to delete this game',
                'code' => 'FORBIDDEN',
            ]);
        }

        // Delete game (example - just return success)
        // In real app: $this->gameRepository->delete($gameId);

        // Return 204 No Content (empty body)
        return new DeleteGame204Resource(null);
    }

    /**
     * Get game board
     *
     * @param string $gameId
     * @return GetBoard200Resource|NotFoundErrorResource
     */
    public function getBoard(string $gameId): GetBoard200Resource|NotFoundErrorResource
    {
        // Business logic: Fetch game board
        // (In real app: query database, get current board state, etc.)

        // Example: Game not found
        if (str_starts_with($gameId, 'notfound-')) {
            return new NotFoundErrorResource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND',
            ]);
        }

        // Example: Mock board data
        $board = new Board(
            squares: [
                ['X', 'O', '.'],
                ['.', 'X', '.'],
                ['.', '.', 'O'],
            ],
            winner: '.',
        );

        return new GetBoard200Resource($board);
    }

    /**
     * Place a mark on the board
     *
     * @param string $gameId
     * @param int $row
     * @param int $column
     * @param MoveRequestDto $request
     * @return PutSquare200Resource|ValidationErrorResource|NotFoundErrorResource|ConflictErrorResource
     */
    public function putSquare(string $gameId, int $row, int $column, MoveRequestDto $request): PutSquare200Resource|ValidationErrorResource|NotFoundErrorResource|ConflictErrorResource
    {
        // Business logic: Validate and place mark
        // (In real app: validate move, update board, check winner, etc.)

        // Example: Validate coordinates
        if ($row < 1 || $row > 3 || $column < 1 || $column > 3) {
            return new ValidationErrorResource([
                'message' => 'Invalid coordinates',
                'errors' => [
                    'row' => $row < 1 || $row > 3 ? ['Row must be between 1 and 3'] : [],
                    'column' => $column < 1 || $column > 3 ? ['Column must be between 1 and 3'] : [],
                ]
            ]);
        }

        // Example: Game not found
        if (str_starts_with($gameId, 'notfound-')) {
            return new NotFoundErrorResource([
                'message' => 'Game not found',
                'code' => 'GAME_NOT_FOUND',
            ]);
        }

        // Example: Square already occupied (409 Conflict)
        if ($gameId === 'occupied-game') {
            return new ConflictErrorResource([
                'message' => 'Square already occupied',
                'code' => 'SQUARE_OCCUPIED',
            ]);
        }

        // Example: Game already finished (409 Conflict)
        if ($gameId === 'finished-game') {
            return new ConflictErrorResource([
                'message' => 'Game is already finished',
                'code' => 'GAME_FINISHED',
            ]);
        }

        // Place mark on board (example)
        $board = new Board(
            squares: [
                ['X', 'O', '.'],
                ['.', 'X', '.'],
                ['.', '.', 'O'],
            ],
            winner: '.',
        );

        // Update board with new mark (simplified)
        $board->squares[$row - 1][$column - 1] = $request->mark;

        return new PutSquare200Resource($board);
    }
}
