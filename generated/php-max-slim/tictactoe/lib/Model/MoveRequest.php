<?php

declare(strict_types=1);

namespace TicTacToe\Model;

/**
 * MoveRequest
 *
 * 
 *
 * @generated
 */
class MoveRequest
{
    /**
     * Mark to place on the board
     */
    public string $mark;

    /**
     * Constructor
     *
     * @param array<string, mixed> $data Named parameters
     */
    public function __construct(array $data = [])
    {
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
            'mark' => $this->mark,
        ];
    }
}
