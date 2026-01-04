<?php

declare(strict_types=1);

namespace TictactoeApi\Model;

class MoveRequest
{
    /**
     * Mark to place on the board
     */
    public string $mark;

    /**
     */
    public function __construct(
        string $mark,
    ) {
        $this->mark = $mark;
    }

    /** @param array<string, mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            mark: $data['mark'],
        );
    }

    /** @return array<string, mixed> */
    public function toArray(): array
    {
        return [
            'mark' => $this->mark,
        ];
    }
}
