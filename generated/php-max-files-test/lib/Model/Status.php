<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Status
 *
 * Current game status including board state and winner
 *
 * @generated
 */
class Status
{
    /**
     */
    public \TictactoeApi\Model\Winner $winner;

    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    public array $board;

    /**
     * Constructor
     */
    public function __construct(
        \TictactoeApi\Model\Winner $winner,
        array $board,
    ) {
        $this->winner = $winner;
        $this->board = $board;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            winner: $data['winner'] ?? null,
            board: $data['board'] ?? null,
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
            'winner' => $this->winner,
            'board' => $this->board,
        ];
    }
}
