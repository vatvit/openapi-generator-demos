<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

final class SquareResponse
{
    /**
     * Board coordinate (1-3)
     */
    public int $row;
    /**
     * Board coordinate (1-3)
     */
    public int $column;
    public \TictactoeApi\Model\Mark $mark;

    /**
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

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            row: $data['row'],
            column: $data['column'],
            mark: \TictactoeApi\Model\Mark::from($data['mark']),
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'row' => $this->row,
            'column' => $this->column,
            'mark' => $this->mark,
        ];
    }
}
