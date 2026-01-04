<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

/**
 * Current game status including board state and winner
 */
class Status
{
    public \TictactoeApi\Model\Winner $winner;
    /**
     * 3x3 game board represented as nested arrays
     * @var array<mixed>
     */
    public \TictactoeApi\Model\Mark[][] $board;

    /**
     * @param array<mixed> $board
     */
    public function __construct(
        \TictactoeApi\Model\Winner $winner,
        \TictactoeApi\Model\Mark[][] $board,
    ) {
        $this->winner = $winner;
        $this->board = $board;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            winner: \TictactoeApi\Model\Winner::from($data['winner']),
            board: $data['board'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'winner' => $this->winner,
            'board' => $this->board,
        ];
    }
}
