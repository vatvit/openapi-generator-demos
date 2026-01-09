<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

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
    public \TictactoeApi\Model\Mark $mark;

    /**
     * Constructor
     */
    public function __construct(
        int $row,
        int $column,
        \TictactoeApi\Model\Mark $mark,
    ) {
        $this->row = $row;
        $this->column = $column;
        $this->mark = $mark;
    }

    /**
     * Create from array
     *
     * @param array<string, mixed> $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            row: $data['row'] ?? null,
            column: $data['column'] ?? null,
            mark: $data['mark'] ?? null,
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
            'row' => $this->row,
            'column' => $this->column,
            'mark' => $this->mark,
        ];
    }
}
