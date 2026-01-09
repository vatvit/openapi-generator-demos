<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Status model.
 *
 * Current game status including board state and winner
 */
class Status
{
    public \TicTacToeApi\Model\Winner $winner;

    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    public array $board;

    /**
     * Create a new Status instance.
     * @param array<mixed> $board
     */
    public function __construct(
        \TicTacToeApi\Model\Winner $winner,
        array $board,
    ) {
        $this->winner = $winner;
        $this->board = $board;
    }

    /**
     * Create instance from array data.
     *
     * @param array<string, mixed> $data
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self(
            winner: $data['winner'] ?? throw new \InvalidArgumentException('winner is required'),
            board: $data['board'] ?? throw new \InvalidArgumentException('board is required')
        );
    }

    /**
     * Convert instance to array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'winner' => $this->winner,
            'board' => $this->board
        ];
    }
}
