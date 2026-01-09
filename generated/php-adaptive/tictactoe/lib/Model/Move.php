<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * Move model.
 */
class Move
{
    /**
     * Sequential move number
     */
    public int $move_number;

    /**
     * Player who made the move
     */
    public string $player_id;

    public string $mark;

    /**
     * Board coordinate (1-3)
     */
    public int $row;

    /**
     * Board coordinate (1-3)
     */
    public int $column;

    /**
     * When the move was made
     */
    public \DateTime $timestamp;

    /**
     * Create a new Move instance.
     */
    public function __construct(
        int $move_number,
        string $player_id,
        string $mark,
        int $row,
        int $column,
        \DateTime $timestamp,
    ) {
        $this->move_number = $move_number;
        $this->player_id = $player_id;
        $this->mark = $mark;
        $this->row = $row;
        $this->column = $column;
        $this->timestamp = $timestamp;
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
            move_number: $data['moveNumber'] ?? throw new \InvalidArgumentException('moveNumber is required'),
            player_id: $data['playerId'] ?? throw new \InvalidArgumentException('playerId is required'),
            mark: $data['mark'] ?? throw new \InvalidArgumentException('mark is required'),
            row: $data['row'] ?? throw new \InvalidArgumentException('row is required'),
            column: $data['column'] ?? throw new \InvalidArgumentException('column is required'),
            timestamp: isset($data['timestamp']) ? new \DateTime($data['timestamp']) : throw new \InvalidArgumentException('timestamp is required')
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
            'moveNumber' => $this->move_number,
            'playerId' => $this->player_id,
            'mark' => $this->mark,
            'row' => $this->row,
            'column' => $this->column,
            'timestamp' => $this->timestamp->format(\DateTimeInterface::ATOM)
        ];
    }
}
