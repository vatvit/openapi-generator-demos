<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * SquareResponse model.
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

    public \TicTacToeApi\Model\Mark $mark;

    /**
     * Create a new SquareResponse instance.
     */
    public function __construct(
        int $row,
        int $column,
        \TicTacToeApi\Model\Mark $mark,
    ) {
        $this->row = $row;
        $this->column = $column;
        $this->mark = $mark;
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
            row: $data['row'] ?? throw new \InvalidArgumentException('row is required'),
            column: $data['column'] ?? throw new \InvalidArgumentException('column is required'),
            mark: $data['mark'] ?? throw new \InvalidArgumentException('mark is required')
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
            'row' => $this->row,
            'column' => $this->column,
            'mark' => $this->mark
        ];
    }
}
