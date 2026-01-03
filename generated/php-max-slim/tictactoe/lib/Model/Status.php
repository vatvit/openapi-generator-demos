<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
    public \TicTacToe\Model\Winner $winner;

    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    public array $board;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->winner = $data['winner'] ?? throw new \InvalidArgumentException('Missing required parameter: winner');
        $this->board = $data['board'] ?? throw new \InvalidArgumentException('Missing required parameter: board');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'winner' => $data['winner'] ?? null,
            'board' => $data['board'] ?? null,
        ]);
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
