<?php

declare(strict_types=1);

namespace TicTacToe\Model;

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
    public int $move_number;

    /**
     * Player who made the move
     */
    public string $player_id;

    /**
     */
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
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->move_number = $data['move_number'] ?? throw new \InvalidArgumentException('Missing required parameter: move_number');
        $this->player_id = $data['player_id'] ?? throw new \InvalidArgumentException('Missing required parameter: player_id');
        $this->mark = $data['mark'] ?? throw new \InvalidArgumentException('Missing required parameter: mark');
        $this->row = $data['row'] ?? throw new \InvalidArgumentException('Missing required parameter: row');
        $this->column = $data['column'] ?? throw new \InvalidArgumentException('Missing required parameter: column');
        $this->timestamp = $data['timestamp'] ?? throw new \InvalidArgumentException('Missing required parameter: timestamp');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'move_number' => $data['moveNumber'] ?? null,
            'player_id' => $data['playerId'] ?? null,
            'mark' => $data['mark'] ?? null,
            'row' => $data['row'] ?? null,
            'column' => $data['column'] ?? null,
            'timestamp' => $data['timestamp'] ?? null,
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
            'moveNumber' => $this->move_number,
            'playerId' => $this->player_id,
            'mark' => $this->mark,
            'row' => $this->row,
            'column' => $this->column,
            'timestamp' => $this->timestamp,
        ];
    }
}
