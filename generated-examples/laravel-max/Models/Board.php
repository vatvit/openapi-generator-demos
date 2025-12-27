<?php

declare(strict_types=1);

namespace LaravelMaxApi\Models;

/**
 * Board DTO
 *
 * Auto-generated from OpenAPI schema: Board
 * Represents a 3x3 TicTacToe board
 */
class Board
{
    /**
     * @param array<array<string>> $squares 3x3 array of marks (".", "X", "O")
     * @param string|null $winner Winner of the game (".", "X", "O") - "." means no winner yet
     */
    public function __construct(
        public array $squares,
        public ?string $winner = '.',
    ) {}

    /**
     * Create empty board
     *
     * @return self
     */
    public static function empty(): self
    {
        return new self([
            ['.', '.', '.'],
            ['.', '.', '.'],
            ['.', '.', '.'],
        ]);
    }

    /**
     * Create from array data
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            squares: $data['board'] ?? self::empty()->squares,
            winner: $data['winner'] ?? '.',
        );
    }

    /**
     * Convert to array
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'board' => $this->squares,
            'winner' => $this->winner,
        ];
    }
}
