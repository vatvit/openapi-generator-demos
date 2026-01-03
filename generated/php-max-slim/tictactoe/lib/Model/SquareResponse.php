<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * SquareResponse
 *
 * 
 *
 * @generated
 */
class SquareResponse
{
    /**
     * Board coordinate (1-3)
     */
    public int $row;

    /**
     * Board coordinate (1-3)
     */
    public int $column;

    /**
     */
    public \TicTacToe\Model\Mark $mark;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
        $this->row = $data['row'] ?? throw new \InvalidArgumentException('Missing required parameter: row');
        $this->column = $data['column'] ?? throw new \InvalidArgumentException('Missing required parameter: column');
        $this->mark = $data['mark'] ?? throw new \InvalidArgumentException('Missing required parameter: mark');
    }

    /**
     * Create from array (JSON data with original keys)
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'row' => $data['row'] ?? null,
            'column' => $data['column'] ?? null,
            'mark' => $data['mark'] ?? null,
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
            'row' => $this->row,
            'column' => $this->column,
            'mark' => $this->mark,
        ];
    }
}
