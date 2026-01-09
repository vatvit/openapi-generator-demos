<?php

declare(strict_types=1);

namespace TicTacToeApi\Model;

/**
 * MoveRequest model.
 */
class MoveRequest
{
    /**
     * Mark to place on the board
     */
    public string $mark;

    /**
     * Create a new MoveRequest instance.
     */
    public function __construct(
        string $mark,
    ) {
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
            'mark' => $this->mark
        ];
    }
}
