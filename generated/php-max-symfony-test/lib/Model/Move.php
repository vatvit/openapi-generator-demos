<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Move
 *
 * 
 *
 * @generated
 */
class Move
{
    /**
     * Sequential move number
     */
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(1)]
    public int $move_number;

    /**
     * Player who made the move
     */
    #[Assert\NotNull]
    #[Assert\Uuid]
    public string $player_id;

    /**
     */
    #[Assert\NotNull]
    public string $mark;

    /**
     * Board coordinate (1-3)
     */
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(3)]
    public int $row;

    /**
     * Board coordinate (1-3)
     */
    #[Assert\NotNull]
    #[Assert\GreaterThanOrEqual(1)]
    #[Assert\LessThanOrEqual(3)]
    public int $column;

    /**
     * When the move was made
     */
    #[Assert\NotNull]
    public \DateTime $timestamp;

    /**
     * Constructor
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
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            move_number: $data['moveNumber'] ?? null,
            player_id: $data['playerId'] ?? null,
            mark: $data['mark'] ?? null,
            row: $data['row'] ?? null,
            column: $data['column'] ?? null,
            timestamp: $data['timestamp'] ?? null,
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
            'moveNumber' => $this->move_number,
            'playerId' => $this->player_id,
            'mark' => $this->mark,
            'row' => $this->row,
            'column' => $this->column,
            'timestamp' => $this->timestamp,
        ];
    }
}

